<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Asegúrate de que los roles existan
        Role::firstOrCreate(['name' => 'estudiante']);
        Role::firstOrCreate(['name' => 'docente']);

        // Insertar usuarios únicos
        User::insert([
            [
                'name' => 'Carlos Ruiz',
                'cedula' => '11223344',
                'email' => 'CarlosRuiz@gmail.com',
                'password' => bcrypt('carlos456'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'María López',
                'cedula' => '44332211',
                'email' => 'MariaLopez@gmail.com',
                'password' => bcrypt('maria456'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fernanda Castro',
                'cedula' => '55443322',
                'email' => 'FernandaCastro@gmail.com',
                'password' => bcrypt('fernanda456'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Asignar roles
        $carlos = User::where('email', 'CarlosRuiz@gmail.com')->first();
        $maria = User::where('email', 'MariaLopez@gmail.com')->first();

        $carlos->assignRole('estudiante');
        $maria->assignRole('docente');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::where('email', 'CarlosRuiz@gmail.com')->delete();
        User::where('email', 'MariaLopez@gmail.com')->delete();
        User::where('email', 'FernandaCastro@gmail.com')->delete();
    }
};
