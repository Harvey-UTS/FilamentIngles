<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->foreignId('estudiante_id') // Clave foránea para el usuario
                  ->constrained('users') // Relacionado con la tabla 'users'
                  ->cascadeOnDelete(); // Eliminar inscripción si el usuario es eliminado
            $table->foreignId('matricula_id') // Clave foránea para la matrícula
                  ->constrained('matriculas') // Relacionado con la tabla 'matriculas'
                  ->cascadeOnDelete(); // Eliminar inscripción si la matrícula es eliminada
            $table->timestamps();
        });

        // Trigger para asignar automáticamente el rol de estudiante al insertar en 'inscripciones'
        DB::unprepared("
            CREATE TRIGGER assign_student_role
            AFTER INSERT ON inscripciones
            FOR EACH ROW
            BEGIN
                INSERT INTO model_has_roles (role_id, model_type, model_id)
                VALUES (
                    (SELECT id FROM roles WHERE name = 'estudiante'),
                    'App\\\\Models\\\\User',
                    NEW.estudiante_id
                );
            END;
        ");
    }

    public function down(): void
    {
        // Eliminar el trigger al revertir la migración
        DB::unprepared("DROP TRIGGER IF EXISTS assign_student_role");

        Schema::dropIfExists('inscripciones');
    }
};