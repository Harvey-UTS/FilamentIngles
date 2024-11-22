<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
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
        static::created(function ($docente) {
            // Encuentra el usuario basado en el email del estudiante (o algún campo común)
            $user = User::where('email', $docente->email)->first();

            if ($user) {
                // Asigna el rol 'estudiante' al nuevo usuario
                $user->assignRole('docente');
            }
        });
    }
}
