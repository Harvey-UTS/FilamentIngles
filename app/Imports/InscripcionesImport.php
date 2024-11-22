<?php
// app/Imports/InscripcionesImport.php
namespace App\Imports;

use App\Models\User;
use App\Models\Matriculas;
use App\Models\Inscripciones;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class InscripcionesImport implements ToModel, WithValidation, WithHeadingRow
{
    public function model(array $row)
    {
        // Validar los datos antes de insertar
        if (!isset($row['cedula'], $row['name'], $row['email'], $row['password'], $row['grupo_id'])) {
            return null; // omitir si falta algún campo
        }

        // Crear usuario (estudiante)
        $user = User::create([
            'cedula' => $row['cedula'],
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
        ]);
        $user->assignRole('estudiante');

        // Crear matrícula asociada al usuario
        $matricula = Matriculas::create([
            'estudiante_id' => $user->id,
            'grupo_id' => $row['grupo_id'],
        ]);

        // Crear inscripción con los IDs correctos
        return new Inscripciones([
            'estudiante_id' => $user->id,
            'matricula_id' => $matricula->id,
        ]);
    }

    public function rules(): array
    {
        return [
            'cedula' => 'required|numeric|unique:users,cedula',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'grupo_id' => 'required|exists:grupos,id',
        ];
    }
}
