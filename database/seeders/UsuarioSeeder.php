<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nombre' => 'Jenifer Álvarez',
            'email' => 'jenifer@gmail.com',
            'password' => Hash::make('Password123') // Encriptada y 8+ caracteres
        ]);

        User::create([
            'nombre' => 'María García',
            'email' => 'maria@gmail.com',
            'password' => Hash::make('Password123') // Encriptada y 8+ caracteres
        ]);

        User::create([
            'nombre' => 'Juan Pérez',
            'email' => 'juan@gmail.com',
            'password' => Hash::make('Password123')
        ]);

        User::create([
            'nombre' => 'Ana Martínez',
            'email' => 'ana@gmail.com',
            'password' => Hash::make('Password123')
        ]);

        User::create([
            'nombre' => 'Carlos López',
            'email' => 'carlos@gmail.com',
            'password' => Hash::make('Password123')
        ]);

        // Puedes agregar más usuarios si necesitas
        echo "✅ Usuarios creados exitosamente\n";
        echo "📧 Email: jenifer@gmail.com | 🔑 Contraseña: Password123\n";
        echo "📧 Email: maria@gmail.com | 🔑 Contraseña: Password123\n";
    }
}












































