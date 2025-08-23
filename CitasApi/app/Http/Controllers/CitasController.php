<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CitasController extends Controller
{
    public function index(){
        $citas = Citas::all();

        return response()->json($citas);
    }

    public function store(Request $request){
        $validador = Validator::make($request->all(),[
            'id_pacientes' => 'required|exists:pacientes,id',
            'id_medicos' => 'required|exists:medicos,id',
            'id_consultorios' => 'required|exists:consultorios,id',
            'fecha' => 'required|date',
            'hora' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'motivo' => 'nullable|string|max:255',
        ]);

        if ($validador->fails()) {
            return response()->json($validador->errors(), 422);
        }

        $cita = Citas::create($request->all());
        return response()->json($cita, 201);
    }

    public function show(string $id){
        $cita = Citas::find($id);
        
        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        return response()->json($cita);
    }

    public function update(Request $request, string $id){

        $cita = Citas::find($id);

        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $validador = Validator::make($request->all(), [
            'id_paciente' => 'exists:pacientes,id',
            'id_medicos' => 'exists:medicos,id',
            'id_consultorios' => 'exists:consultorios,id',
            'fecha' => 'date',
            'hora' => 'string|max:255',
            'estado' => 'string|max:255',
            'motivo' => 'nullable|string|max:255',
        ]);

        if ($validador->fails()) {
            return response()->json($validador->errors(), 422);
        }

        $cita->update($request->all());
        return response()->json($cita);
    }

    public function destroy(string $id){
        $cita = Citas::find($id);

        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $cita->delete();
        return response()->json(['message' => 'Cita eliminada']);
    }

    // CONSULTAS ADICIONALES

    public function listarCitasActivas(){

        $citas = Citas::where('estado', 'Confirmada')->get();
        return response()->json($citas);
    }

    public function listarCitasGripa(){

        $citas = Citas::where('motivo', 'like', '%Gripa%')
                    ->with(['pacientes', 'medicos', 'consultorios'])
                    ->get();

        return response()->json($citas);
    }

    public function listarCitasPacientes30(){

        $fechaReferencia = now()->subYears(30); // fecha límite (hace 30 años)

        $citas = Citas::whereHas('pacientes', function($q) use ($fechaReferencia){
                        $q->where('fecha_nacimiento', '<', $fechaReferencia);
                    })
                    ->with(['pacientes', 'medicos', 'consultorios'])
                    ->get();

        return response()->json($citas);
    }



}
