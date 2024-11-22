<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // Si usas Spatie para roles
use App\Models\Matriculas;
use App\Models\Inscripciones;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles; // Si no usas Spatie, elimina HasRoles

    // Nombre de la tabla asociada (opcional si sigue el estándar)
    protected $table = 'users';

    // Campos asignables en masa
    protected $fillable = [
        'cedula',
        'name',
        'email',
        'password',
    ];

    // Ocultar campos sensibles al serializar
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast de atributos
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     
    /*Relación con el modelo Matricula.*/
    public function matriculas(){
        return $this->hasMany(Matriculas::class, 'estudiante_id');}

    /*Relación con el modelo Inscripcion.*/
    public function inscripciones(){
        return $this->hasMany(Inscripciones::class, 'estudiante_id');}
}