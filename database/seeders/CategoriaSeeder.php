<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'nombre' => 'Fantasía',
            'descripcion' => 'Libros de mundos mágicos, criaturas sobrenaturales y aventuras épicas.',
        ]);

        Category::create([
            'nombre' => 'Romance',
            'descripcion' => 'Historias de amor y relaciones.',
        ]);

        Category::create([
            'nombre' => 'Drama',
            'descripcion' => 'Historias intensas y emocionales.',
        ]);
    }
}
