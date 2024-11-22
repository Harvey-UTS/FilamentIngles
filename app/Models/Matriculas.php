<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Grupos;
use App\Models\Inscripciones;
use App\Models\User;

class Matriculas extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada (opcional si sigue el estándar pluralizado)
    protected $table = 'matriculas';

    // Campos asignables en masa
    protected $fillable = [
        'estudiante_id',
        'grupo_id',
        'estado',
        'nota_final',
    ];
     
    /*Relación con el modelo User (estudiante).*/
    public function estudiante(){
        return $this->belongsTo(User::class, 'estudiante_id');}
        
    /*Relación con el modelo Inscripcion.*/
    public function inscripciones(){
        return $this->hasMany(Inscripciones::class, 'matricula_id');}
        
    /*Relación con el modelo Grupo (asumiendo que tienes un modelo de grupos)*/
    public function grupo(){
        return $this->belongsTo(Grupos::class, 'grupo_id');}

}