@extends('layouts.app')
@section('title', $categoria->nombre)
@section('page-title', 'Detalles de Categoría')
@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-700 px-8 py-6 text-white">
            <h1 class="text-3xl font-bold">🏷️ {{ $categoria->nombre }}</h1>
            <p class="text-indigo-100 mt-1">{{ $categoria->descripcion ?? 'Sin descripción' }}</p>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">ID de Categoría</p>
                    <p class="text-2xl font-bold text-blue-600">#{{ $categoria->id }}</p>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Libros Asignados</p>
                    <p class="text-2xl font-bold text-green-600">{{ $categoria->libros->count() }}</p>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Creada</p>
                    <p class="text-lg font-bold text-purple-600">{{ $categoria->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('categorias.index') }}" 
                   class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
                <a href="{{ route('categorias.edit', $categoria->id) }}" 
                   class="inline-flex items-center bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </div>

    @if($categoria->libros->isNotEmpty())
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">📚 Libros en esta Categoría</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($categoria->libros as $libro)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                        <h3 class="font-semibold text-gray-900 mb-1">{{ $libro->titulo }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $libro->autor }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">{{ $libro->anio }}</span>
                            <a href="{{ route('libros.show', $libro) }}" 
                               class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                Ver detalles →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <i class="fas fa-book-open text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">No hay libros en esta categoría</h3>
            <p class="text-gray-500">Asigna libros a esta categoría al crearlos o editarlos</p>
        </div>
    @endif
</div>
@endsection