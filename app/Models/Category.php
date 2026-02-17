<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
     use HasFactory;
    protected $table = 'categorias';

    protected $fillable = ['nombre', 'descripcion'];

    // Relaciones
   public function libros()
    {
        return $this->belongsToMany(Book::class, 'libro_categorias', 'id_categoria', 'id_libro');
    }

    
}
