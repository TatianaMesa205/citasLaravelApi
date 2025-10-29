<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use \stdClass;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registrar(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,  
            'token' => $token,
            'token_type' => 'Bearer'
        ], 201);
    }

    public function login(Request $request){

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'No tienes la autorizacion'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Hi ' . $user->name,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tuviste un exitoso cierre de sesion'
        ];
    }

    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => Auth::user(), // el usuario autenticado
        ], 200);
    }

    public function editarPerfil(Request $request)
    {
        $user = auth()->user(); // Obtiene el usuario autenticado

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|nullable|string|min:8|confirmed', // requiere password_confirmation
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Actualizar solo los campos enviados
        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('password') && !empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'message' => 'Perfil actualizado correctamente ✅',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'updated_at' => $user->updated_at,
            ],
        ], 200);
    }

    public function destroy(Request $request)
    {
        $user = $request->user();

        if ($user) {
            // Buscar si hay un paciente con el mismo email del usuario
            $paciente = \App\Models\Pacientes::where('email', $user->email)->first();

            if ($paciente) {
                $paciente->delete();
            }

            // Eliminar la cuenta del usuario
            $user->delete();

            return response()->json([
                "message" => "Tu cuenta fue eliminada correctamente. Esperamos verte de nuevo 💜"
            ]);
        }

        return response()->json(["message" => "No se encontró el usuario."], 404);
    }

    public function listarAdmins()
    {
        // Consulta solo los usuarios con rol 'ADMIN'
        $admins = User::where('role', 'ADMIN')
            ->select('name', 'email') // Solo devuelve estos campos
            ->get();

        // Si no hay resultados, devuelve un mensaje
        if ($admins->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron administradores registrados.'
            ], 404);
        }

        // Si hay resultados, devuelve la lista
        return response()->json([
            'admins' => $admins
        ], 200);
    }


}