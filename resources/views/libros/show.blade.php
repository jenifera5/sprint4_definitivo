@extends('layouts.app')

@section('title', $libro->titulo)

@section('page-title', 'Detalles del Libro')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="md:flex">
            {{-- Imagen del libro --}}
            <div class="md:flex-shrink-0 bg-gradient-to-br from-blue-500 to-blue-700 p-8 flex items-center justify-center">
                @php
                    $imagen = 'img/libros/libro' . $libro->id . '.png';
                @endphp
                @if(file_exists(public_path($imagen)))
                    <img src="{{ asset($imagen) }}" 
                         alt="Portada de {{ $libro->titulo }}" 
                         class="w-64 h-96 object-cover rounded-lg shadow-2xl">
                @else
                    <div class="w-64 h-96 bg-white rounded-lg shadow-2xl flex flex-col items-center justify-center text-gray-400">
                        <i class="fas fa-book text-6xl mb-4"></i>
                        <p class="text-sm">Sin portada</p>
                    </div>
                @endif
            </div>

            {{-- Información del libro --}}
            <div class="p-8 flex-1">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $libro->titulo }}</h1>
                    <p class="text-lg text-gray-600">
                        <i class="fas fa-user-edit text-blue-600 mr-2"></i>
                        por <strong>{{ $libro->autor }}</strong>
                    </p>
                </div>

                {{-- Detalles --}}
                <div class="space-y-4">
                    {{-- Año --}}
                    <div class="flex items-center text-gray-700">
                        <div class="w-32 font-semibold flex items-center">
                            <i class="fas fa-calendar text-blue-600 mr-2 w-5"></i>
                            Año:
                        </div>
                        <div>{{ $libro->anio }}</div>
                    </div>

                    {{-- Disponibilidad --}}
                    <div class="flex items-center text-gray-700">
                        <div class="w-32 font-semibold flex items-center">
                            <i class="fas fa-warehouse text-blue-600 mr-2 w-5"></i>
                            Disponibles:
                        </div>
                        <div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                {{ $libro->disponibles > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $libro->disponibles > 0 ? '✓' : '✗' }} 
                                {{ $libro->disponibles }} {{ $libro->disponibles === 1 ? 'copia' : 'copias' }}
                            </span>
                        </div>
                    </div>

                    {{-- Categorías --}}
                    <div class="flex items-start text-gray-700">
                        <div class="w-32 font-semibold flex items-center pt-1">
                            <i class="fas fa-tags text-blue-600 mr-2 w-5"></i>
                            Categorías:
                        </div>
                        <div class="flex-1">
                            @if($libro->categorias->isNotEmpty())
                                <div class="flex flex-wrap gap-2">
                                    @foreach($libro->categorias as $categoria)
                                        <span class="inline-block bg-blue-600 text-white text-sm px-4 py-2 rounded-lg shadow-sm">
                                            <i class="fas fa-tag mr-1"></i>{{ $categoria->nombre }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-400 italic">Sin categorías asignadas</span>
                            @endif
                        </div>
                    </div>

                    {{-- ID --}}
                    <div class="flex items-center text-gray-700">
                        <div class="w-32 font-semibold flex items-center">
                            <i class="fas fa-fingerprint text-blue-600 mr-2 w-5"></i>
                            ID:
                        </div>
                        <div class="font-mono text-gray-500">#{{ $libro->id }}</div>
                    </div>
                </div>

                {{-- Estado --}}
                <div class="mt-6 p-4 rounded-lg {{ $libro->disponibles > 0 ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                    @if($libro->disponibles > 0)
                        <p class="text-green-800 flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-2 text-lg"></i>
                            <strong>Libro disponible para préstamo</strong>
                        </p>
                    @else
                        <p class="text-red-800 flex items-center">
                            <i class="fas fa-exclamation-circle text-red-600 mr-2 text-lg"></i>
                            <strong>No hay copias disponibles actualmente</strong>
                        </p>
                    @endif
                </div>

                {{-- Botones de acción --}}
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('libros.index') }}" 
                       class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i> Volver al listado
                    </a>

                    <a href="{{ route('libros.edit', $libro->id) }}" 
                       class="inline-flex items-center bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-lg transition duration-200">
                        <i class="fas fa-edit mr-2"></i> Editar libro
                    </a>

                    <form action="{{ route('libros.destroy', $libro->id) }}" method="POST" class="inline"
                          onsubmit="return confirm('¿Seguro que deseas eliminar el libro \"{{ $libro->titulo }}\"?\n\nEsta acción eliminará:\n- El libro\n- Sus relaciones con categorías\n\nNo se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-200">
                            <i class="fas fa-trash mr-2"></i> Eliminar libro
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Información adicional de categorías --}}
    @if($libro->categorias->isNotEmpty())
        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                Información de Categorías
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($libro->categorias as $categoria)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                        <h3 class="font-semibold text-gray-800 mb-2">
                            <i class="fas fa-tag text-blue-600 mr-2"></i>{{ $categoria->nombre }}
                        </h3>
                        @if($categoria->descripcion)
                            <p class="text-sm text-gray-600">{{ $categoria->descripcion }}</p>
                        @else
                            <p class="text-sm text-gray-400 italic">Sin descripción</p>
                        @endif
                        <div class="mt-3">
                            <a href="{{ route('categorias.show', $categoria->id) }}" 
                               class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                Ver más libros de esta categoría →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection























