@extends('layouts.app')

@section('title', 'Crear Préstamo')

@section('page-title', 'Crear Préstamo')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">📋 Crear Nuevo Préstamo</h1>
        <p class="text-gray-600 mt-2">Registra un nuevo préstamo de libro</p>
    </div>

    {{-- Mostrar errores --}}
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-circle text-red-600 mr-2"></i>
                <h3 class="font-semibold text-red-800">Por favor, corrige los siguientes errores:</h3>
            </div>
            <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Mensaje de error --}}
    @if(session('error'))
        <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 flex items-center">
            <i class="fas fa-exclamation-circle text-red-600 mr-3 text-xl"></i>
            <span class="text-red-800 font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Advertencia si no hay libros disponibles --}}
    @if($libros->isEmpty())
        <div class="mb-6 p-4 rounded-lg bg-yellow-50 border border-yellow-200">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mt-1 mr-3"></i>
                <div>
                    <p class="font-semibold text-yellow-800">No hay libros disponibles</p>
                    <p class="text-sm text-yellow-700 mt-1">
                        Todos los libros están prestados. Espera a que se devuelva alguno o 
                        <a href="{{ route('libros.create') }}" class="underline font-semibold">agrega más libros al catálogo</a>.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('prestamos.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Usuario --}}
        <div>
            <label for="id_usuario" class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-user text-blue-600 mr-1"></i> Usuario *
            </label>
            @if($usuarios->isEmpty())
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-yellow-800">
                        No hay usuarios registrados. 
                        <a href="{{ route('usuarios.create') }}" class="underline font-semibold">Crea un usuario primero</a>
                    </p>
                </div>
            @else
                <select 
                    name="id_usuario" 
                    id="id_usuario"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('id_usuario') border-red-500 @enderror"
                    required>
                    <option value="">Selecciona un usuario...</option>
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ old('id_usuario') == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->nombre }} ({{ $usuario->email }})
                        </option>
                    @endforeach
                </select>
            @endif
            @error('id_usuario')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Libro --}}
        <div>
            <label for="id_libro" class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-book text-blue-600 mr-1"></i> Libro *
            </label>
            @if($libros->isEmpty())
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-yellow-800">
                        No hay libros disponibles para préstamo en este momento.
                    </p>
                </div>
            @else
                <select 
                    name="id_libro" 
                    id="id_libro"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('id_libro') border-red-500 @enderror"
                    required>
                    <option value="">Selecciona un libro...</option>
                    @foreach ($libros as $libro)
                        <option value="{{ $libro->id }}" {{ old('id_libro') == $libro->id ? 'selected' : '' }}
                                data-disponibles="{{ $libro->disponibles }}">
                            {{ $libro->titulo }} - {{ $libro->autor }} ({{ $libro->disponibles }} disponibles)
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-info-circle"></i> Solo se muestran libros con copias disponibles
                </p>
            @endif
            @error('id_libro')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Fecha Préstamo --}}
        <div>
            <label for="fecha_prestamo" class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-calendar-plus text-blue-600 mr-1"></i> Fecha de Préstamo *
            </label>
            <input 
                type="date" 
                id="fecha_prestamo"
                name="fecha_prestamo" 
                value="{{ old('fecha_prestamo', now()->format('Y-m-d')) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('fecha_prestamo') border-red-500 @enderror"
                required>
            @error('fecha_prestamo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Fecha Devolución --}}
        <div>
            <label for="fecha_devolucion" class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-calendar-check text-blue-600 mr-1"></i> Fecha de Devolución *
            </label>
            <input 
                type="date" 
                id="fecha_devolucion"
                name="fecha_devolucion" 
                value="{{ old('fecha_devolucion', now()->addDays(15)->format('Y-m-d')) }}"
                min="{{ now()->addDay()->format('Y-m-d') }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('fecha_devolucion') border-red-500 @enderror"
                required>
            <p class="text-xs text-gray-500 mt-1">
                <i class="fas fa-info-circle"></i> Debe ser posterior a la fecha de préstamo
            </p>
            @error('fecha_devolucion')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Información adicional --}}
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="font-semibold text-blue-900 mb-2">
                <i class="fas fa-info-circle mr-2"></i>Información importante
            </h3>
            <ul class="text-sm text-blue-800 space-y-1">
                <li>• El préstamo se creará como "Activo" automáticamente</li>
                <li>• Las copias disponibles del libro se reducirán en 1</li>
                <li>• Puedes marcar el préstamo como devuelto desde el listado</li>
                <li>• Al devolver, las copias disponibles se incrementarán</li>
            </ul>
        </div>

        {{-- Botones --}}
        <div class="flex items-center gap-4 pt-4">
            <button 
                type="submit" 
                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-200 shadow-md hover:shadow-lg"
                {{ $libros->isEmpty() || $usuarios->isEmpty() ? 'disabled' : '' }}>
                <i class="fas fa-save mr-2"></i> Crear Préstamo
            </button>
            <a 
                href="{{ route('prestamos.index') }}" 
                class="flex-1 text-center bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg transition duration-200">
                <i class="fas fa-times mr-2"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<script>
    // Actualizar fecha mínima de devolución cuando cambie la fecha de préstamo
    document.getElementById('fecha_prestamo').addEventListener('change', function() {
        const fechaPrestamo = new Date(this.value);
        fechaPrestamo.setDate(fechaPrestamo.getDate() + 1);
        
        const fechaMin = fechaPrestamo.toISOString().split('T')[0];
        document.getElementById('fecha_devolucion').min = fechaMin;
    });
</script>
@endsection

































































