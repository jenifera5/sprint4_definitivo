@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('page-title', 'Crear Usuario')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">👤 Crear Nuevo Usuario</h1>
        <p class="text-gray-600 mt-2">Completa los datos para registrar un nuevo usuario</p>
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

    <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Nombre --}}
        <div>
            <label for="nombre" class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-user text-blue-600 mr-1"></i> Nombre Completo *
            </label>
            <input 
                type="text" 
                id="nombre"
                name="nombre" 
                value="{{ old('nombre') }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nombre') border-red-500 @enderror" 
                placeholder="Ej: Juan Pérez"
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
                value="{{ old('email') }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror" 
                placeholder="Ej: usuario@example.com"
                required>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Contraseña --}}
        <div>
            <label for="password" class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-lock text-blue-600 mr-1"></i> Contraseña *
            </label>
            <div class="relative">
                <input 
                    type="password" 
                    id="password"
                    name="password" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-12 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror" 
                    placeholder="Mínimo 8 caracteres"
                    required>
                <button 
                    type="button" 
                    onclick="togglePassword('password')"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                    <i class="fas fa-eye" id="password-icon"></i>
                </button>
            </div>
            <p class="text-xs text-gray-500 mt-1">
                <i class="fas fa-info-circle"></i> Debe tener al menos 8 caracteres
            </p>
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirmar Contraseña --}}
        <div>
            <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-lock text-blue-600 mr-1"></i> Confirmar Contraseña *
            </label>
            <div class="relative">
                <input 
                    type="password" 
                    id="password_confirmation"
                    name="password_confirmation" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-12 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                    placeholder="Repite la contraseña"
                    required>
                <button 
                    type="button" 
                    onclick="togglePassword('password_confirmation')"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                    <i class="fas fa-eye" id="password_confirmation-icon"></i>
                </button>
            </div>
            <p class="text-xs text-gray-500 mt-1">
                <i class="fas fa-info-circle"></i> Debe coincidir con la contraseña
            </p>
        </div>

        {{-- Indicador de seguridad de contraseña --}}
        <div id="password-strength" class="hidden">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-semibold text-gray-700">Seguridad de la contraseña:</span>
                <span id="strength-text" class="text-sm font-semibold"></span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div id="strength-bar" class="h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex items-center gap-4 pt-4">
            <button 
                type="submit" 
                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
                <i class="fas fa-save mr-2"></i> Guardar Usuario
            </button>
            <a 
                href="{{ route('usuarios.index') }}" 
                class="flex-1 text-center bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg transition duration-200">
                <i class="fas fa-times mr-2"></i> Cancelar
            </a>
        </div>
    </form>
</div>

{{-- JavaScript para mostrar/ocultar contraseñas y verificar seguridad --}}
<script>
    // Función para mostrar/ocultar contraseña
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

    // Verificar seguridad de contraseña
    document.getElementById('password').addEventListener('input', function(e) {
        const password = e.target.value;
        const strengthDiv = document.getElementById('password-strength');
        const strengthBar = document.getElementById('strength-bar');
        const strengthText = document.getElementById('strength-text');
        
        if (password.length === 0) {
            strengthDiv.classList.add('hidden');
            return;
        }
        
        strengthDiv.classList.remove('hidden');
        
        let strength = 0;
        let text = '';
        let color = '';
        
        // Calcular fuerza
        if (password.length >= 8) strength += 25;
        if (password.length >= 12) strength += 25;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 25;
        if (/\d/.test(password)) strength += 15;
        if (/[@$!%*?&#]/.test(password)) strength += 10;
        
        // Determinar texto y color
        if (strength < 40) {
            text = 'Débil';
            color = '#ef4444';
        } else if (strength < 70) {
            text = 'Media';
            color = '#f59e0b';
        } else {
            text = 'Fuerte';
            color = '#10b981';
        }
        
        strengthBar.style.width = strength + '%';
        strengthBar.style.backgroundColor = color;
        strengthText.textContent = text;
        strengthText.style.color = color;
    });

    // Verificar que las contraseñas coincidan
    document.getElementById('password_confirmation').addEventListener('input', function(e) {
        const password = document.getElementById('password').value;
        const confirmation = e.target.value;
        
        if (confirmation.length === 0) return;
        
        if (password === confirmation) {
            this.style.borderColor = '#10b981';
        } else {
            this.style.borderColor = '#ef4444';
        }
    });
</script>
@endsection



































