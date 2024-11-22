<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Estudiante extends Model
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $table = 'users'; // Usando la misma tabla 'users'

    // Campos específicos que son asignables en el modelo de Estudiante
    protected $fillable = [
        'name',
        'cedula',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // Filtro para asegurarse de que solo se obtienen estudiantes
    protected static function booted()
    {
        static::created(function ($estudiante) {
            // Encuentra el usuario basado en el email del estudiante (o algún campo común)
            $user = User::where('email', $estudiante->email)->first();

            if ($user) {
                // Asigna el rol 'estudiante' al nuevo usuario
                $user->assignRole('estudiante');
            }
        });
    }

    // Mostrar todos los estudiantes
    public static function getAllEstudiantes()
    {
        return Estudiante::role('estudiante')->get(); // Obtiene todos los usuarios con rol de estudiante
    }
}
