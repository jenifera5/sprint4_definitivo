@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('page-title', 'Editar Usuario')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">✏️ Editar Usuario</h1>
        <p class="text-gray-600 mt-2">Modifica los datos del usuario: <strong>{{ $usuario->nombre }}</strong></p>
    </div>

    {{-- Mostrar errores de validación --}}
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

    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div>
            <label for="nombre" class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-user text-blue-600 mr-1"></i> Nombre Completo *
            </label>
            <input 
                type="text" 
                id="nombre"
                name="nombre" 
                value="{{ old('nombre', $usuario->nombre) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nombre') border-red-500 @enderror" 
                required>
            @error('nombre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-envelope text-blue-600 mr-1"></i> Email *
            </label>
            <input 
                type="email" 
                id="email"
                name="email" 
                value="{{ old('email', $usuario->email) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror" 
                required>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Sección de cambio de contraseña --}}
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                <div class="flex-1">
                    <h3 class="font-semibold text-blue-900 mb-1">Cambiar Contraseña</h3>
                    <p class="text-sm text-blue-800 mb-3">
                        Deja estos campos vacíos si no deseas cambiar la contraseña actual
                    </p>
                    
                    <div class="space-y-4">
                        {{-- Nueva Contraseña --}}
                        <div>
                            <label for="password" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-lock text-blue-600 mr-1"></i> Nueva Contraseña
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password"
                                    name="password" 
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-12 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white @error('password') border-red-500 @enderror" 
                                    placeholder="Mínimo 8 caracteres (opcional)">
                                <button 
                                    type="button" 
                                    onclick="togglePassword('password')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-eye" id="password-icon"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-600 mt-1">
                                <i class="fas fa-info-circle"></i> Debe tener al menos 8 caracteres
                            </p>
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Confirmar Nueva Contraseña --}}
                        <div>
                            <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-lock text-blue-600 mr-1"></i> Confirmar Nueva Contraseña
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password_confirmation"
                                    name="password_confirmation" 
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-12 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white" 
                                    placeholder="Repite la nueva contraseña">
                                <button 
                                    type="button" 
                                    onclick="togglePassword('password_confirmation')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-eye" id="password_confirmation-icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Información del usuario --}}
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
            <h3 class="font-semibold text-gray-800 mb-2">Información adicional</h3>
            <div class="text-sm text-gray-600 space-y-1">
                <p><strong>ID:</strong> #{{ $usuario->id }}</p>
                <p><strong>Registrado:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Última actualización:</strong> {{ $usuario->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex items-center gap-4 pt-4">
            <button 
                type="submit" 
                class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
                <i class="fas fa-save mr-2"></i> Actualizar Usuario
            </button>
            <a 
                href="{{ route('usuarios.index') }}" 
                class="flex-1 text-center bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg transition duration-200">
                <i class="fas fa-times mr-2"></i> Cancelar
            </a>
        </div>
    </form>
</div>

{{-- JavaScript para mostrar/ocultar contraseñas --}}
<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '-icon');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Verificar que las contraseñas coincidan si se está cambiando
    document.getElementById('password_confirmation').addEventListener('input', function(e) {
        const password = document.getElementById('password').value;
        const confirmation = e.target.value;
        
        if (password.length === 0 && confirmation.length === 0) {
            this.style.borderColor = '#d1d5db';
            return;
        }
        
        if (password === confirmation) {
            this.style.borderColor = '#10b981';
        } else {
            this.style.borderColor = '#ef4444';
        }
    });

    // Advertir si se llena la confirmación sin contraseña
    document.getElementById('password_confirmation').addEventListener('blur', function(e) {
        const password = document.getElementById('password').value;
        const confirmation = e.target.value;
        
        if (confirmation.length > 0 && password.length === 0) {
            alert('Debes introducir la nueva contraseña antes de confirmarla');
            this.value = '';
        }
    });
</script>
@endsection