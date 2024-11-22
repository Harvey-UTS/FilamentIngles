<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripciones extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada al modelo
    protected $table = 'inscripciones';

    // Campos asignables masivamente
    protected $fillable = [
        'estudiante_id',
        'matricula_id',
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

    // Relación con el modelo Matriculas
    public function matricula()
    {
        return $this->belongsTo(Matriculas::class, 'matricula_id');
    }
}