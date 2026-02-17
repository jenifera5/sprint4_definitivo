@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Iniciar sesión
            </h2>
            <p class="text-gray-500 text-sm">
                Accede a tu cuenta para continuar
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Correo electrónico
                </label>
                <input type="email" name="email"
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                       required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Contraseña
                </label>
                <input type="password" name="password"
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                       required>
            </div>

            <div class="flex items-center justify-between mb-4">
                <label class="flex items-center text-sm">
                    <input type="checkbox" name="remember" class="mr-2">
                    Recordarme
                </label>

                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
                Iniciar sesión
            </button>

            <div class="text-center mt-6 text-sm">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline">
                    Regístrate aquí
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
