<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
     protected $fillable = [
        'id_pacientes',
        'id_medicos',
        'id_consultorios',
        'fecha',
        'hora',
        'estado', // Por ejemplo: 'pendiente', 'confirmada', 'cancelada'
        'motivo',
    ];
    public function pacientes(){
        return $this->belongsTo(Pacientes::class, 'id_pacientes', 'id'); // belongsTo significa de muchos a uno
    }
    public function medicos(){
        return $this->belongsTo(Medicos::class, 'id_medicos', 'id'); // belongsTo significa de muchos a uno
    }
    public function consultorios(){
        return $this->belongsTo(Consultorios::class, 'id_consultorios', 'id'); // belongsTo significa de muchos a uno
    }
}
