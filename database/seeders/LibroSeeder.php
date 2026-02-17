<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use App\Models\Category;

class LibroSeeder extends Seeder
{
    public function run(): void
    {
        $fantasia = Category::where('nombre', 'Fantasía')->first();
        $romance  = Category::where('nombre', 'Romance')->first();

        $l1 = Book::create([
            'titulo' => 'El duque y yo',
            'autor' => 'Julia Quinn',
            'anio' => 2024,
            'disponibles' => 1,
        ]);

        $l2 = Book::create([
            'titulo' => 'Sempiterno',
            'autor' => 'Joana Marcús',
            'anio' => 2025,
            'disponibles' => 5,
        ]);

        $l3 = Book::create([
            'titulo' => 'Alas de sangre',
            'autor' => 'Rebecca Yarros',
            'anio' => 2023,
            'disponibles' => 0,
        ]);

        // Asociamos a categorías
        $romance?->libros()->attach($l1->id);
        $fantasia?->libros()->attach($l2->id);
        $fantasia?->libros()->attach($l3->id);
    }
}
