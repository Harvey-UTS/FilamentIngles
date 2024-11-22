<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->string('nombre'); // Nombre del curso
            $table->text('descripcion'); // Descripción del curso
            $table->foreignId('requisito_id')->nullable() // Curso de nivel anterior (requisito)
                ->constrained('cursos') // Referencia a la misma tabla
                ->nullOnDelete(); // Si el curso requerido se elimina, este requisito será null
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
