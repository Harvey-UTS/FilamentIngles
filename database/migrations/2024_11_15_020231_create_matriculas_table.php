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
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('estudiante_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->foreignId('grupo_id')
                  ->constrained('grupos')
                  ->cascadeOnDelete();
            $table->enum('estado', ['no aprobado', 'cancelado', 'pendiente'])
                  ->default('pendiente');
            $table->decimal('nota_final', 2, 1)->nullable();
            $table->timestamps();
        });

        // Agregar la restricción CHECK para nota_final utilizando SQL raw
        DB::statement("ALTER TABLE matriculas ADD CONSTRAINT chk_nota_final CHECK (nota_final >= 0.0 AND nota_final <= 5.0)");

        // Crear el trigger para validar que el usuario tiene el rol de estudiante
        DB::unprepared("
            CREATE TRIGGER check_estudiante_role
            BEFORE INSERT ON matriculas
            FOR EACH ROW
            BEGIN
                DECLARE role_count INT DEFAULT 0;
                
                SELECT COUNT(*) INTO role_count
                FROM model_has_roles
                WHERE model_id = NEW.estudiante_id 
                  AND role_id = (SELECT id FROM roles WHERE name = 'estudiante' LIMIT 1);

                IF role_count = 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'El usuario no tiene el rol de estudiante.';
                END IF;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar el trigger
        DB::unprepared("DROP TRIGGER IF EXISTS check_estudiante_role");
        
        // Eliminar restricción CHECK
        DB::statement("ALTER TABLE matriculas DROP CONSTRAINT IF EXISTS chk_nota_final");

        // Eliminar tabla
        Schema::dropIfExists('matriculas');
    }
};