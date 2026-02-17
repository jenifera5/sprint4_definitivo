@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Crear cuenta
            </h2>
            <p class="text-gray-500 text-sm">
                Completa tus datos para registrarte
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Nombre
                </label>
                <input type="text" 
                       name="nombre"
                       value="{{ old('nombre') }}"
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                       required>
                @error('nombre')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Correo electrónico
                </label>
                <input type="email" 
                       name="email"
                       value="{{ old('email') }}"
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                       required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Contraseña
                </label>
                <input type="password" 
                       name="password"
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                       required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Confirmar contraseña
                </label>
                <input type="password" 
                       name="password_confirmation"
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                       required>
                @error('password_confirmation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
                Crear cuenta
            </button>

            <div class="text-center mt-6 text-sm">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="text-indigo-600 font-medium hover:underline">
                    Inicia sesión aquí
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
