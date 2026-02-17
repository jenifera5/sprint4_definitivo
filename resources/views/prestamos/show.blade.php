@extends('layouts.app')
@section('title', 'Detalles del Préstamo')
@section('page-title', 'Detalles del Préstamo')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-purple-500 to-purple-700 px-8 py-6 text-white">
            <h1 class="text-3xl font-bold">📋 Préstamo #{{ $prestamo->id }}</h1>
            <p class="text-purple-100 mt-1">Información detallada del préstamo</p>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-user text-blue-600 mr-2"></i> Usuario
                    </h3>
                    <p class="text-lg font-bold text-gray-900">{{ $prestamo->usuario->nombre ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-600">{{ $prestamo->usuario->email ?? '' }}</p>
                </div>

                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-book text-green-600 mr-2"></i> Libro
                    </h3>
                    <p class="text-lg font-bold text-gray-900">{{ $prestamo->libro->titulo ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-600">{{ $prestamo->libro->autor ?? '' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Fecha de Préstamo</p>
                    <p class="text-lg font-bold text-gray-900">
                        <i class="fas fa-calendar-plus text-blue-600 mr-2"></i>
                        {{ \Carbon\Carbon::parse($prestamo->fecha_prestamo)->format('d/m/Y') }}
                    </p>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Fecha de Devolución</p>
                    <p class="text-lg font-bold text-gray-900">
                        <i class="fas fa-calendar-check text-green-600 mr-2"></i>
                        {{ \Carbon\Carbon::parse($prestamo->fecha_devolucion)->format('d/m/Y') }}
                    </p>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Estado</p>
                    @if($prestamo->devuelto)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i> Devuelto
                        </span>
                    @else
                        @php
                            $fechaDevolucion = \Carbon\Carbon::parse($prestamo->fecha_devolucion);
                            $esRetrasado = $fechaDevolucion->isPast();
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold 
                            {{ $esRetrasado ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                            <i class="fas {{ $esRetrasado ? 'fa-exclamation-triangle' : 'fa-clock' }} mr-1"></i>
                            {{ $esRetrasado ? 'Retrasado' : 'Activo' }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('prestamos.index') }}" 
                   class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>

                @if(!$prestamo->devuelto)
                    <form action="{{ route('prestamos.marcar-devuelto', $prestamo) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition"
                                onclick="return confirm('¿Confirmar devolución del libro?')">
                            <i class="fas fa-check mr-2"></i> Marcar como Devuelto
                        </button>
                    </form>
                @endif

                <a href="{{ route('prestamos.edit', $prestamo->id) }}" 
                   class="inline-flex items-center bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>

                <form action="{{ route('prestamos.destroy', $prestamo->id) }}" method="POST" class="inline"
                      onsubmit="return confirm('¿Seguro que deseas eliminar este préstamo?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                        <i class="fas fa-trash mr-2"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
































































