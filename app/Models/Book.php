<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table = 'libros';
    protected $fillable = ['titulo', 'autor', 'anio', 'disponibles'];

    // Relaciones
    public function prestamos()
    {
        return $this->hasMany(Loan::class, 'id_libro');
    }

    public function categorias()
    {
        return $this->belongsToMany(Category::class, 'libro_categorias', 'id_libro', 'id_categoria');
    }
}
