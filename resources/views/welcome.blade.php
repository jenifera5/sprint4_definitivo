Welcome.blade · PHP
Copiar

{{-- resources/views/welcome.blade.php --}}
@extends('layouts.app')

@section('title', 'Inicio - Biblioteca Virtual')

@section('page-title', 'Inicio')

@section('content')
   <!-- Hero section -->
<section class="bg-white rounded-xl shadow-lg p-8 text-center mb-10">
    <h2 class="text-4xl font-bold text-gray-900 mb-4">📚 Bienvenido/a a la Biblioteca Virtual</h2>
    <p class="text-gray-600 text-lg max-w-2xl mx-auto">
        Explora libros, administra usuarios y gestiona préstamos fácilmente desde el sistema.
    </p>
</section>

    <!-- Cards de acceso rápido -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Card Libros -->
        <a href="{{ route('libros.index') }}" class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 p-6">
            <div class="flex items-center justify-between mb-4">
                <i class="fas fa-book text-4xl opacity-80"></i>
                <span class="text-3xl font-bold opacity-90">📚</span>
            </div>
            <h3 class="text-xl font-semibold mb-2">Libros</h3>
            <p class="text-blue-100 text-sm">Gestiona el catálogo de libros</p>
        </a>

        <!-- Card Usuarios -->
        <a href="{{ route('usuarios.index') }}" class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 p-6">
            <div class="flex items-center justify-between mb-4">
                <i class="fas fa-users text-4xl opacity-80"></i>
                <span class="text-3xl font-bold opacity-90">👥</span>
            </div>
            <h3 class="text-xl font-semibold mb-2">Usuarios</h3>
            <p class="text-green-100 text-sm">Administra los usuarios</p>
        </a>

        <!-- Card Préstamos -->
        <a href="{{ route('prestamos.index') }}" class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 p-6">
            <div class="flex items-center justify-between mb-4">
                <i class="fas fa-handshake text-4xl opacity-80"></i>
                <span class="text-3xl font-bold opacity-90">📋</span>
            </div>
            <h3 class="text-xl font-semibold mb-2">Préstamos</h3>
            <p class="text-purple-100 text-sm">Gestiona los préstamos</p>
        </a>

        <!-- Card Categorías -->
        <a href="{{ route('categorias.index') }}" class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 p-6">
            <div class="flex items-center justify-between mb-4">
                <i class="fas fa-tags text-4xl opacity-80"></i>
                <span class="text-3xl font-bold opacity-90">🏷️</span>
            </div>
            <h3 class="text-xl font-semibold mb-2">Categorías</h3>
            <p class="text-yellow-100 text-sm">Organiza las categorías</p>
        </a>
    </div>

    <!-- Libros recomendados -->
    <section class="mt-10">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-2xl font-bold text-gray-800">📖 Libros Recomendados</h3>
                <p class="text-sm text-gray-500 mt-1">Nuestras bibliotecas recomiendan estos títulos destacados</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Libro 1 -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                <img src="{{ asset('img/libro1.jpg') }}" alt="Carnaval" class="w-full h-64 object-cover">
                <div class="p-4">
                    <h4 class="text-lg font-semibold text-gray-800 mb-1">Caraval</h4>
                    <p class="text-sm text-gray-500 mb-3">Stephanie Garber</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-blue-600 font-semibold">Fantasía</span>
                        <span class="text-yellow-500">⭐⭐⭐⭐⭐</span>
                    </div>
                </div>
            </div>

            <!-- Libro 2 -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                <img src="{{ asset('img/libro2.jpg') }}" alt="El duque y yo" class="w-full h-64 object-cover">
                <div class="p-4">
                    <h4 class="text-lg font-semibold text-gray-800 mb-1">El duque y yo</h4>
                    <p class="text-sm text-gray-500 mb-3">Julia Quinn</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-blue-600 font-semibold">Romance</span>
                        <span class="text-yellow-500">⭐⭐⭐⭐⭐</span>
                    </div>
                </div>
            </div>

            <!-- Libro 3 -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                <img src="{{ asset('img/libro3.jpg') }}" alt="La asistenta" class="w-full h-64 object-cover">
                <div class="p-4">
                    <h4 class="text-lg font-semibold text-gray-800 mb-1">La asistenta</h4>
                    <p class="text-sm text-gray-500 mb-3">Freida McFadden</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-blue-600 font-semibold">Thriller</span>
                        <span class="text-yellow-500">⭐⭐⭐⭐⭐</span>
                    </div>
                </div>
            </div>

            <!-- Libro 4 -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                <img src="{{ asset('img/libro4.jpg') }}" alt="Powerless" class="w-full h-64 object-cover">
                <div class="p-4">
                    <h4 class="text-lg font-semibold text-gray-800 mb-1">Powerless</h4>
                    <p class="text-sm text-gray-500 mb-3">Lauren Roberts</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-blue-600 font-semibold">Fantasía</span>
                        <span class="text-yellow-500">⭐⭐⭐⭐⭐</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de estadísticas -->
    <section class="mt-10 bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">📊 Estadísticas Rápidas</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <p class="text-3xl font-bold text-blue-600">150</p>
                <p class="text-sm text-gray-600 mt-1">Libros</p>
            </div>
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <p class="text-3xl font-bold text-green-600">45</p>
                <p class="text-sm text-gray-600 mt-1">Usuarios</p>
            </div>
            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <p class="text-3xl font-bold text-purple-600">23</p>
                <p class="text-sm text-gray-600 mt-1">Préstamos activos</p>
            </div>
            <div class="text-center p-4 bg-yellow-50 rounded-lg">
                <p class="text-3xl font-bold text-yellow-600">12</p>
                <p class="text-sm text-gray-600 mt-1">Categorías</p>
            </div>
        </div>
    </section>
@endsection