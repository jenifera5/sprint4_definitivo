@extends('layouts.app')
@section('title', 'Categorías')
@section('page-title', 'Gestión de Categorías')
@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">🏷️ Lista de Categorías</h1>
                <p class="text-gray-600 mt-1">Organiza los libros por categorías</p>
            </div>
            <a href="{{ route('categorias.create') }}"
               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                <i class="fas fa-plus mr-2"></i> Nueva Categoría
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
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nombre</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Descripción</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Libros</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($categorias as $categoria)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $categoria->id }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="font-semibold text-gray-900">{{ $categoria->nombre }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ Str::limit($categoria->descripcion, 60) ?? 'Sin descripción' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                    <i class="fas fa-book mr-1"></i> {{ $categoria->libros_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <div class="flex items-center gap-2 justify-end">
                                    <a href="{{ route('categorias.show', $categoria) }}"
                                       class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('categorias.edit', $categoria) }}"
                                       class="inline-flex items-center px-3 py-2 bg-yellow-500 rounded-lg text-white hover:bg-yellow-600 transition"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="inline"
                                          onsubmit="return confirm('{{ $categoria->libros_count > 0 ? '⚠️ Esta categoría tiene ' . $categoria->libros_count . ' libros asociados.\n\n' : '' }}¿Seguro que deseas eliminar esta categoría?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-2 bg-red-600 rounded-lg text-white hover:bg-red-700 transition"
                                                title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-tags text-gray-300 text-6xl mb-4"></i>
                                    <h3 class="text-lg font-semibold text-gray-600 mb-2">No hay categorías registradas</h3>
                                    <p class="text-gray-500 mb-4">Comienza creando la primera categoría</p>
                                    <a href="{{ route('categorias.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition">
                                        <i class="fas fa-plus mr-2"></i> Crear Categoría
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categorias->isNotEmpty())
            <div class="mt-6 pt-4 border-t border-gray-200">
                <div class="flex items-center justify-between text-sm text-gray-600">
                    <span><i class="fas fa-tags text-blue-600 mr-1"></i><strong>{{ $categorias->count() }}</strong> categorías en total</span>
                    <span><i class="fas fa-book text-blue-600 mr-1"></i><strong>{{ $categorias->sum('libros_count') }}</strong> libros categorizados</span>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
