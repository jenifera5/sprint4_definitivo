@extends('layouts.app')

@section('title', 'Usuarios')

@section('page-title', 'Gestión de Usuarios')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">👥 Lista de Usuarios</h1>
                <p class="text-gray-600 mt-1">Gestiona los usuarios de la biblioteca</p>
            </div>

            <a href="{{ route('usuarios.create') }}"
               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
                <i class="fas fa-plus mr-2"></i> Nuevo Usuario
            </a>
        </div>

        {{-- Flash de éxito --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-3 text-xl"></i>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Flash de error --}}
        @if (session('error'))
            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 flex items-center">
                <i class="fas fa-exclamation-circle text-red-600 mr-3 text-xl"></i>
                <span class="text-red-800 font-medium">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Tabla --}}
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            ID
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Préstamos
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Registrado
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($usuarios as $usuario)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                #{{ $usuario->id }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-semibold text-gray-900">{{ $usuario->nombre }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                    {{ $usuario->email }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $prestamosCount = $usuario->prestamos->count();
                                    $prestamosActivos = $usuario->prestamos->where('devuelto', false)->count();
                                @endphp
                                <div class="flex flex-col items-center gap-1">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $prestamosActivos > 0 ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-600' }}">
                                        <i class="fas fa-book-reader mr-1"></i>
                                        {{ $prestamosActivos }} activos
                                    </span>
                                    @if($prestamosCount > $prestamosActivos)
                                        <span class="text-xs text-gray-500">
                                            {{ $prestamosCount - $prestamosActivos }} históricos
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                    {{ $usuario->created_at->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <div class="flex items-center gap-2 justify-end">
                                    <a href="{{ route('usuarios.show', $usuario) }}"
                                       class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-150"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('usuarios.edit', $usuario) }}"
                                       class="inline-flex items-center px-3 py-2 bg-yellow-500 rounded-lg text-white hover:bg-yellow-600 transition duration-150"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="inline"
                                          onsubmit="return confirm('¿Seguro que deseas eliminar al usuario \"{{ $usuario->nombre }}\"?\n\n{{ $usuario->prestamos->count() > 0 ? 'ADVERTENCIA: Este usuario tiene ' . $usuario->prestamos->count() . ' préstamos asociados.' : 'Esta acción no se puede deshacer.' }}');">
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
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
                                    <h3 class="text-lg font-semibold text-gray-600 mb-2">No hay usuarios registrados</h3>
                                    <p class="text-gray-500 mb-4">Comienza agregando el primer usuario del sistema</p>
                                    <a href="{{ route('usuarios.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition">
                                        <i class="fas fa-plus mr-2"></i> Añadir Usuario
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Información adicional --}}
        @if($usuarios->isNotEmpty())
            <div class="mt-6 pt-4 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Total Usuarios</p>
                                <p class="text-2xl font-bold text-blue-600">{{ $usuarios->count() }}</p>
                            </div>
                            <i class="fas fa-users text-blue-600 text-3xl opacity-50"></i>
                        </div>
                    </div>

                    <div class="bg-purple-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Con Préstamos Activos</p>
                                <p class="text-2xl font-bold text-purple-600">
                                    {{ $usuarios->filter(function($u) { return $u->prestamos->where('devuelto', false)->count() > 0; })->count() }}
                                </p>
                            </div>
                            <i class="fas fa-book-reader text-purple-600 text-3xl opacity-50"></i>
                        </div>
                    </div>

                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Sin Préstamos</p>
                                <p class="text-2xl font-bold text-green-600">
                                    {{ $usuarios->filter(function($u) { return $u->prestamos->count() === 0; })->count() }}
                                </p>
                            </div>
                            <i class="fas fa-user-check text-green-600 text-3xl opacity-50"></i>
                        </div>
                    </div>

                    <div class="bg-orange-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Nuevos (Este Mes)</p>
                                <p class="text-2xl font-bold text-orange-600">
                                    {{ $usuarios->filter(function($u) { return $u->created_at->isCurrentMonth(); })->count() }}
                                </p>
                            </div>
                            <i class="fas fa-user-plus text-orange-600 text-3xl opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection



































