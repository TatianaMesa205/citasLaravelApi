<?php

use App\Http\Controllers\CitasController;
use App\Http\Controllers\ConsultoriosController;
use App\Http\Controllers\EspecialidadesController;
use App\Http\Controllers\MedicosController;
use App\Http\Controllers\PacientesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('listarCitas', [CitasController::class, 'index']);
Route::post('crearCitas', [CitasController::class, 'store']);
Route::get('citas/{id}', [CitasController::class, 'show']);
Route::put('actualizarCitas/{id}', [CitasController::class, 'update']);
Route::delete('eliminarCitas/{id}', [CitasController::class, 'destroy']);

Route::get('listarConsultorios', [ConsultoriosController::class, 'index']);
Route::post('crearConsultorios', [ConsultoriosController::class, 'store']);
Route::get('consultorios/{id}', [ConsultoriosController::class, 'show']);
Route::put('actualizarConsultorios/{id}', [ConsultoriosController::class, 'update']);
Route::delete('eliminarConsultorios/{id}', [ConsultoriosController::class, 'destroy']);

Route::get('listarEspecialidades', [EspecialidadesController::class, 'index']);
Route::post('crearEspecialidades', [EspecialidadesController::class, 'store']);
Route::get('especialidades/{id}', [EspecialidadesController::class, 'show']);
Route::put('actualizarEspecialidades/{id}', [EspecialidadesController::class, 'update']);
Route::delete('eliminarEspecialidades/{id}', [EspecialidadesController::class, 'destroy']);

Route::get('listarMedicos', [MedicosController::class, 'index']);
Route::post('crearMedicos', [MedicosController::class, 'store']);
Route::get('medicos/{id}', [MedicosController::class, 'show']);
Route::put('actualizarMedicos/{id}', [MedicosController::class, 'update']);
Route::delete('eliminarMedicos/{id}', [MedicosController::class, 'destroy']);

Route::get('listarPacientes', [PacientesController::class, 'index']);
Route::post('crearPacientes', [PacientesController::class, 'store']);
Route::get('pacientes/{id}', [PacientesController::class, 'show']);
Route::put('actualizarPacientes/{id}', [PacientesController::class, 'update']);
Route::delete('eliminarPacientes/{id}', [PacientesController::class, 'destroy']);

// CONSULTAS ADICIONALES

Route::get('listarHotmail', [PacientesController::class, 'listarHotmail']);
Route::get('listar20Anios', [MedicosController::class, 'listar20Anios']);
Route::get('listarConsultoriosSegundoP', [ConsultoriosController::class, 'listarConsultoriosSegundoP']);
Route::get('listarMenores', [PacientesController::class, 'listarMenores']);
Route::get('listarCitasActivas', [CitasController::class, 'listarCitasActivas']);
Route::get('listarApellidosM', [PacientesController::class, 'listarApellidosM']);
Route::get('listarCitasGripa', [CitasController::class, 'listarCitasGripa']);
Route::get('listarMedicosCardiologia', [MedicosController::class, 'listarMedicosCardiologia']);
Route::get('listarPacientesBogota', [PacientesController::class, 'listarPacientesBogota']);
Route::get('listarCitasPacientes30', [CitasController::class, 'listarCitasPacientes30']);

