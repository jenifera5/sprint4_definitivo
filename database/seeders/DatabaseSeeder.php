<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       

        // Llamamos a otros seeders
        $this->call([
            UsuarioSeeder::class,
            CategoriaSeeder::class,
            LibroSeeder::class,
            PrestamoSeeder::class, 
        ]);
    }
}
