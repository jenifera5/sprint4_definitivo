@extends('layouts.app')

@section('title', 'Préstamos')

@section('page-title', 'Gestión de Préstamos')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">📋 Lista de Préstamos</h1>
                <p class="text-gray-600 mt-1">Gestiona los préstamos de la biblioteca</p>
            </div>
            <a href="{{ route('prestamos.create') }}"
               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
                <i class="fas fa-plus mr-2"></i> Nuevo Préstamo
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-3 text-xl"></i>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 flex items-center">
                <i class="fas fa-exclamation-circle text-red-600 mr-3 text-xl"></i>
                <span class="text-red-800 font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Usuario</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Libro</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">F. Préstamo</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">F. Devolución</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Estado</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($prestamos as $prestamo)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $prestamo->id }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="font-semibold text-gray-900">{{ $prestamo->usuario->nombre ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ $prestamo->usuario->email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="font-semibold text-gray-900">{{ $prestamo->libro->titulo ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ $prestamo->libro->autor ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($prestamo->fecha_prestamo)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($prestamo->fecha_devolucion)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($prestamo->devuelto)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Devuelto
                                    </span>
                                @else
                                    @php
                                        $fechaDevolucion = \Carbon\Carbon::parse($prestamo->fecha_devolucion);
                                        $esRetrasado = $fechaDevolucion->isPast();
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                        {{ $esRetrasado ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        <i class="fas {{ $esRetrasado ? 'fa-exclamation-triangle' : 'fa-clock' }} mr-1"></i>
                                        {{ $esRetrasado ? 'Retrasado' : 'Activo' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <div class="flex items-center gap-2 justify-end">
                                    @if(!$prestamo->devuelto)
                                        <form action="{{ route('prestamos.marcar-devuelto', $prestamo) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-2 bg-green-600 rounded-lg text-white hover:bg-green-700 transition duration-150"
                                                    title="Marcar como devuelto"
                                                    onclick="return confirm('¿Confirmar devolución del libro?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('prestamos.show', $prestamo) }}"
                                       class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-150"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('prestamos.edit', $prestamo) }}"
                                       class="inline-flex items-center px-3 py-2 bg-yellow-500 rounded-lg text-white hover:bg-yellow-600 transition duration-150"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('prestamos.destroy', $prestamo) }}" method="POST" class="inline"
                                          onsubmit="return confirm('¿Seguro que deseas eliminar este préstamo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-2 bg-red-600 rounded-lg text-white hover:bg-red-700 transition duration-150"
                                                title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-book-reader text-gray-300 text-6xl mb-4"></i>
                                    <h3 class="text-lg font-semibold text-gray-600 mb-2">No hay préstamos registrados</h3>
                                    <p class="text-gray-500 mb-4">Comienza creando el primer préstamo</p>
                                    <a href="{{ route('prestamos.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition">
                                        <i class="fas fa-plus mr-2"></i> Crear Préstamo
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($prestamos->isNotEmpty())
            <div class="mt-6 pt-4 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Total Préstamos</p>
                                <p class="text-2xl font-bold text-blue-600">{{ $prestamos->count() }}</p>
                            </div>
                            <i class="fas fa-book-reader text-blue-600 text-3xl opacity-50"></i>
                        </div>
                    </div>

                    <div class="bg-yellow-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Activos</p>
                                <p class="text-2xl font-bold text-yellow-600">
                                    {{ $prestamos->where('devuelto', false)->count() }}
                                </p>
                            </div>
                            <i class="fas fa-clock text-yellow-600 text-3xl opacity-50"></i>
                        </div>
                    </div>

                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Devueltos</p>
                                <p class="text-2xl font-bold text-green-600">
                                    {{ $prestamos->where('devuelto', true)->count() }}
                                </p>
                            </div>
                            <i class="fas fa-check-circle text-green-600 text-3xl opacity-50"></i>
                        </div>
                    </div>

                    <div class="bg-red-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Retrasados</p>
                                <p class="text-2xl font-bold text-red-600">
                                    {{ $prestamos->filter(function($p) { 
                                        return !$p->devuelto && \Carbon\Carbon::parse($p->fecha_devolucion)->isPast(); 
                                    })->count() }}
                                </p>
                            </div>
                            <i class="fas fa-exclamation-triangle text-red-600 text-3xl opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection









































































