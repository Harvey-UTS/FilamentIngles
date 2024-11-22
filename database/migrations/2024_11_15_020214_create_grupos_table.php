<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('grupos', function (Blueprint $table) {
        $table->id(); // ID autoincremental
        $table->string('nombre'); // Nombre del grupo
        $table->foreignId('curso_id') // Clave foránea a la tabla 'cursos'
            ->constrained('cursos')
            ->cascadeOnDelete();
        $table->foreignId('semestre_academico_id') // Clave foránea a la tabla 'semestres_academicos'
            ->constrained('semestres_academicos')
            ->cascadeOnDelete();
        $table->foreignId('docente_id') // Clave foránea para el usuario con rol docente
            ->constrained('users') // Relacionado con la tabla de usuarios
            ->cascadeOnDelete(); // Eliminar grupo si se elimina el docente
        $table->timestamps();
    });

    DB::unprepared("
    CREATE TRIGGER check_Docente_role
    BEFORE INSERT ON grupos
    FOR EACH ROW
    BEGIN
        DECLARE role_count INT;
        SELECT COUNT(*) INTO role_count
        FROM model_has_roles
        WHERE model_id = NEW.docente_id AND role_id = (SELECT id FROM roles WHERE name = 'docente');

        IF role_count = 0 THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'El usuario no tiene el rol de docente.';
        END IF;
    END;
    ");
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS check_Docente_role");
        Schema::dropIfExists('grupos');
    }
};
