<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Importar DB para ejecutar statements

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('semestres_academicos', function (Blueprint $table) {
            $table->id(); 
            $table->integer('año'); 
            $table->string('nombre'); 
            $table->integer('periodo_academico'); 
            $table->timestamps();
        });

        // Añadir restricciones CHECK utilizando SQL raw
        DB::statement("ALTER TABLE semestres_academicos ADD CONSTRAINT chk_año CHECK (año >= 2000 AND año <= 2100)");
        DB::statement("ALTER TABLE semestres_academicos ADD CONSTRAINT chk_periodo_academico CHECK (periodo_academico >= 1 AND periodo_academico <= 6)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar restricciones antes de eliminar la tabla
        Schema::table('semestres_academicos', function (Blueprint $table) {
            DB::statement("ALTER TABLE semestres_academicos DROP CONSTRAINT IF EXISTS chk_año");
            DB::statement("ALTER TABLE semestres_academicos DROP CONSTRAINT IF EXISTS chk_periodo_academico");
        });

        Schema::dropIfExists('semestres_academicos');
    }
};