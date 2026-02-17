@extends('layouts.app')
@section('title', 'Crear Categoría')
@section('page-title', 'Crear Categoría')
@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">🏷️ Crear Nueva Categoría</h1>
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
            <ul class="list-disc list-inside text-red-700 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('categorias.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-tag text-blue-600 mr-1"></i> Nombre *
            </label>
            <input type="text" name="nombre" value="{{ old('nombre') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500" 
                   placeholder="Ej: Ciencia Ficción" required>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-align-left text-blue-600 mr-1"></i> Descripción
            </label>
            <textarea name="descripcion" rows="4"
                      class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500"
                      placeholder="Descripción de la categoría...">{{ old('descripcion') }}</textarea>
        </div>
        <div class="flex gap-4">
            <button type="submit" 
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                <i class="fas fa-save mr-2"></i> Guardar Categoría
            </button>
            <a href="{{ route('categorias.index') }}" 
               class="flex-1 text-center bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                <i class="fas fa-times mr-2"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection