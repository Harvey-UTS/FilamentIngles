<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Grupos;

class Cursos extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'requisito_id'];

    public function grupos()
    {
        return $this->hasMany(Grupos::class);
    }

    public function requisito()
    {
        return $this->belongsTo(Cursos::class, 'requisito_id'); // Devuelve un valor por defecto si es null
    }
}
