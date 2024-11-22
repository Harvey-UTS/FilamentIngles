<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Grupos;

class semestresAcademicos extends Model
{
    use HasFactory;

    protected $fillable = ['año', 'nombre', 'periodo_academico'];

    public function grupos()
    {
        return $this->hasMany(Grupos::class);
    }
}