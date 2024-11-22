<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cursos;
use App\Models\semestresAcademicos;
use App\Models\User;
use App\Models\Matriculas;

class Grupos extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'curso_id', 'semestre_academico_id', 'docente_id'];

    public function curso()
    {
        return $this->belongsTo(Cursos::class);
    }

    public function semestreAcademico()
    {
        return $this->belongsTo(semestresAcademicos::class);
    }

    public function docente()
    {
        return $this->belongsTo(User::class, 'docente_id');
    }

    public function matriculas()
    {
        return $this->hasMany(Matriculas::class);
    }
}