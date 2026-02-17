@extends('layouts.app')

@section('title', 'Libros')

@section('page-title', 'Gestión de Libros')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">📖 Lista de Libros</h1>
                <p class="text-gray-600 mt-1">Gestiona el catálogo de la biblioteca</p>
            </div>

            <a href="{{ route('libros.create') }}"
               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
                <i class="fas fa-plus mr-2"></i> Nuevo Libro
            </a>
        </div>

        {{-- Flash de éxito --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-3 text-xl"></i>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
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
                            Título
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Autor
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Año
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Categorías
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Disponibles
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($libros as $libro)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                #{{ $libro->id }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="font-semibold text-gray-900">{{ $libro->titulo }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $libro->autor }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $libro->anio }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($libro->categorias->isNotEmpty())
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($libro->categorias as $categoria)
                                            <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-1 rounded-full">
                                                <i class="fas fa-tag text-blue-600 mr-1"></i>{{ $categoria->nombre }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs italic">Sin categorías</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $libro->disponibles > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $libro->disponibles > 0 ? '✓' : '✗' }} {{ $libro->disponibles }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <div class="flex items-center gap-2 justify-end">
                                    <a href="{{ route('libros.show', $libro) }}"
                                       class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-150"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('libros.edit', $libro) }}"
                                       class="inline-flex items-center px-3 py-2 bg-yellow-500 rounded-lg text-white hover:bg-yellow-600 transition duration-150"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('libros.destroy', $libro) }}" method="POST" class="inline"
                                          onsubmit="return confirm('¿Seguro que deseas eliminar el libro \"{{ $libro->titulo }}\"?\n\nEsta acción no se puede deshacer.');">
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
                                    <i class="fas fa-book-open text-gray-300 text-6xl mb-4"></i>
                                    <h3 class="text-lg font-semibold text-gray-600 mb-2">No hay libros registrados</h3>
                                    <p class="text-gray-500 mb-4">Comienza agregando tu primer libro al catálogo</p>
                                    <a href="{{ route('libros.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition">
                                        <i class="fas fa-plus mr-2"></i> Añadir Libro
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Información adicional --}}
        @if($libros->isNotEmpty())
            <div class="mt-6 pt-4 border-t border-gray-200">
                <div class="flex items-center justify-between text-sm text-gray-600">
                    <div class="flex items-center gap-6">
                        <span>
                            <i class="fas fa-book text-blue-600 mr-1"></i>
                            <strong>{{ $libros->count() }}</strong> {{ $libros->count() === 1 ? 'libro' : 'libros' }} en total
                        </span>
                        <span>
                            <i class="fas fa-check-circle text-green-600 mr-1"></i>
                            <strong>{{ $libros->where('disponibles', '>', 0)->count() }}</strong> disponibles
                        </span>
                        <span>
                            <i class="fas fa-times-circle text-red-600 mr-1"></i>
                            <strong>{{ $libros->where('disponibles', 0)->count() }}</strong> agotados
                        </span>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection






















