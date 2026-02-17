@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Recuperar contraseña
            </h2>
            <p class="text-gray-500 text-sm mt-2">
                Introduce tu correo y te enviaremos un enlace para restablecer tu contraseña.
            </p>
        </div>

        <!-- Mensaje de éxito -->
        @if (session('status'))
            <div class="mb-4 text-sm text-green-600 bg-green-50 p-3 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Correo electrónico
                </label>
                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                @error('email')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
                Enviar enlace de recuperación
            </button>

            <div class="text-center mt-6 text-sm">
                ¿Recordaste tu contraseña?
                <a href="{{ route('login') }}" class="text-indigo-600 font-medium hover:underline">
                    Volver al login
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
