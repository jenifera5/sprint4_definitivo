@extends('layouts.app')

@section('title', 'Editar Libro')

@section('page-title', 'Editar Libro')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">✏️ Editar Libro</h1>
        <p class="text-gray-600 mt-2">Modifica los datos del libro: <strong>{{ $libro->titulo }}</strong></p>
    </div>

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-circle text-red-600 mr-2"></i>
                <h3 class="font-semibold text-red-800">Por favor, corrige los siguientes errores:</h3>
            </div>
            <ul class="list-disc list-inside text-red-700 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('libros.update', $libro->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Título --}}
        <div>
            <label for="titulo" class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-book text-blue-600 mr-1"></i> Título *
            </label>
            <input 
                type="text" 
                id="titulo"
                name="titulo" 
                value="{{ old('titulo', $libro->titulo) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('titulo') border-red-500 @enderror" 
                required>
            @error('titulo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Autor --}}
        <div>
            <label for="autor" class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-user-edit text-blue-600 mr-1"></i> Autor *
            </label>
            <input 
                type="text" 
                id="autor"
                name="autor" 
                value="{{ old('autor', $libro->autor) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('autor') border-red-500 @enderror" 
                required>
            @error('autor')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Año --}}
        <div>
            <label for="anio" class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-calendar text-blue-600 mr-1"></i> Año de Publicación *
            </label>
            <input 
                type="number" 
                id="anio"
                name="anio" 
                value="{{ old('anio', $libro->anio) }}"
                min="1000"
                max="{{ now()->year }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('anio') border-red-500 @enderror" 
                required>
            @error('anio')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Disponibles --}}
        <div>
            <label for="disponibles" class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-warehouse text-blue-600 mr-1"></i> Copias Disponibles *
            </label>
            <input 
                type="number" 
                id="disponibles"
                name="disponibles" 
                value="{{ old('disponibles', $libro->disponibles) }}"
                min="0" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('disponibles') border-red-500 @enderror" 
                required>
            @error('disponibles')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Categorías (Múltiples) --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-tags text-blue-600 mr-1"></i> Categorías *
            </label>
            <p class="text-sm text-gray-600 mb-3">Selecciona una o más categorías (mantén Ctrl/Cmd para seleccionar varias)</p>
            
            @php
                // Obtener IDs de las categorías actuales del libro
                $categoriasSeleccionadas = old('categorias', $libro->categorias->pluck('id')->toArray());
            @endphp
            
            @if($categorias->isEmpty())
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-yellow-800">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        No hay categorías disponibles. 
                        <a href="{{ route('categorias.create') }}" class="underline font-semibold">Crea una categoría primero</a>
                    </p>
                </div>
            @else
                <select 
                    name="categorias[]" 
                    id="categorias"
                    multiple 
                    size="5"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('categorias') border-red-500 @enderror"
                    required>
                    @foreach($categorias as $categoria)
                        <option 
                            value="{{ $categoria->id }}" 
                            {{ in_array($categoria->id, $categoriasSeleccionadas) ? 'selected' : '' }}
                            class="py-2">
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-info-circle"></i> Mantén presionado Ctrl (Windows/Linux) o Cmd (Mac) para seleccionar múltiples categorías
                </p>
            @endif
            
            @error('categorias')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Categorías actuales (informativo) --}}
        @if($libro->categorias->isNotEmpty())
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm font-semibold text-blue-800 mb-2">
                    <i class="fas fa-info-circle mr-1"></i> Categorías actuales:
                </p>
                <div class="flex flex-wrap gap-2">
                    @foreach($libro->categorias as $categoria)
                        <span class="inline-block bg-blue-600 text-white text-xs px-3 py-1 rounded-full">
                            {{ $categoria->nombre }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Botones --}}
        <div class="flex items-center gap-4 pt-4">
            <button 
                type="submit" 
                class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
                <i class="fas fa-save mr-2"></i> Actualizar Libro
            </button>
            <a 
                href="{{ route('libros.index') }}" 
                class="flex-1 text-center bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg transition duration-200">
                <i class="fas fa-times mr-2"></i> Cancelar
            </a>
        </div>
    </form>
</div>

{{-- Script para mejorar la experiencia de selección múltiple --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectElement = document.getElementById('categorias');
        if (selectElement) {
            // Resaltar visualmente las opciones seleccionadas al cargar
            Array.from(selectElement.options).forEach(option => {
                if (option.selected) {
                    option.style.backgroundColor = '#3b82f6';
                    option.style.color = 'white';
                }
            });

            // Resaltar al cambiar selección
            selectElement.addEventListener('change', function() {
                Array.from(this.options).forEach(option => {
                    if (option.selected) {
                        option.style.backgroundColor = '#3b82f6';
                        option.style.color = 'white';
                    } else {
                        option.style.backgroundColor = '';
                        option.style.color = '';
                    }
                });
            });
        }
    });
</script>
@endsection






















