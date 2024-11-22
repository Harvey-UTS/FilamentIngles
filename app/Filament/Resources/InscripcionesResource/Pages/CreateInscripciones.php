<?php
namespace App\Filament\Resources\InscripcionesResource\Pages;

use App\Filament\Resources\InscripcionesResource;
use App\Models\User;
use App\Models\Matriculas;
use App\Models\Inscripciones;
use Illuminate\Support\Facades\Hash;
use Filament\Resources\Pages\CreateRecord;

class CreateInscripciones extends CreateRecord
{
    protected static string $resource = InscripcionesResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Crear usuario (estudiante)
        $user = User::create([
            'cedula' => $data['cedula'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole('estudiante');

        // Crear matrícula asociada al usuario
        $matricula = Matriculas::create([
            'estudiante_id' => $user->id,
            'grupo_id' => $data['grupo_id'],
        ]);

        // Crear inscripción con los IDs correctos
        return Inscripciones::create([
            'estudiante_id' => $user->id,
            'matricula_id' => $matricula->id,
        ]);
    }
}
