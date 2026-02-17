<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categorias = Category::withCount('libros')->get();
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:categorias,nombre|max:255',
            'descripcion' => 'nullable|max:500',
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio',
            'nombre.unique' => 'Ya existe una categoría con este nombre',
        ]);
        
        Category::create($request->all());
        
        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada correctamente');
    }

    public function show(Category $categoria)
    {
        $categoria->load('libros');
        return view('categorias.show', compact('categoria'));
    }

    public function edit(Category $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Category $categoria)
    {
        $request->validate([
            'nombre' => 'required|unique:categorias,nombre,' . $categoria->id . '|max:255',
            'descripcion' => 'nullable|max:500',
        ]);
        
        $categoria->update($request->all());
        
        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada correctamente');
    }

    public function destroy(Category $categoria)
    {
        if ($categoria->libros()->count() > 0) {
            return redirect()->route('categorias.index')
                ->with('error', 'No se puede eliminar una categoría que tiene libros asignados');
        }
        
        $categoria->delete();
        
        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada correctamente');
    }
}