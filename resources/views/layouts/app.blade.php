<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Biblioteca Virtual')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">

<!-- Overlay móvil -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

<!-- Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 h-screen w-64 bg-gradient-to-b from-blue-600 to-blue-800 text-white shadow-2xl z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">

    <!-- Logo -->
    <div class="flex items-center justify-between p-6 border-b border-blue-500">
        <div class="flex items-center gap-3">
            <i class="fas fa-book-open text-3xl"></i>
            <div>
                <h1 class="text-xl font-bold">Biblioteca</h1>
                <p class="text-xs text-blue-200">Virtual</p>
            </div>
        </div>
        <button id="close-sidebar" class="lg:hidden text-white">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <!-- Navegación -->
    <nav class="mt-6 px-4">
        <ul class="space-y-2">

            <li>
                <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-700 {{ request()->is('/') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-home w-5"></i>
                    <span>Inicio</span>
                </a>
            </li>

            <li>
                <a href="{{ route('libros.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-700 {{ request()->is('libros*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-book w-5"></i>
                    <span>Libros</span>
                </a>
            </li>

            <li>
                <a href="{{ route('usuarios.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-700 {{ request()->is('usuarios*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-users w-5"></i>
                    <span>Usuarios</span>
                </a>
            </li>

            <li>
                <a href="{{ route('prestamos.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-700 {{ request()->is('prestamos*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-handshake w-5"></i>
                    <span>Préstamos</span>
                </a>
            </li>

            <li>
                <a href="{{ route('categorias.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-700 {{ request()->is('categorias*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-tags w-5"></i>
                    <span>Categorías</span>
                </a>
            </li>

        </ul>
    </nav>
</aside>

<!-- Contenido principal -->
<div class="lg:ml-64 min-h-screen flex flex-col">

    <!-- HEADER -->
    <header class="bg-white shadow-md sticky top-0 z-30">
        <div class="flex items-center justify-between px-6 py-4">

            <button id="open-sidebar" class="lg:hidden text-gray-700 text-2xl">
                <i class="fas fa-bars"></i>
            </button>

            <h2 class="text-xl font-semibold text-gray-800">
                @yield('page-title', 'Inicio')
            </h2>

            <div class="flex items-center gap-6">

                <span class="text-sm text-gray-500 hidden sm:block">
                    {{ date('d/m/Y') }}
                </span>

                @auth
                    <div class="flex items-center gap-3">
                        <i class="fas fa-user-circle text-2xl text-gray-600"></i>

                        <span class="text-sm font-semibold text-gray-700">
                            {{ Auth::user()->nombre ?? Auth::user()->name }}
                        </span>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="text-sm text-red-600 hover:text-red-800 transition">
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                @endauth

                @guest
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}"
                           class="text-sm font-medium text-blue-600 hover:text-blue-800">
                            Iniciar sesión
                        </a>

                        <a href="{{ route('register') }}"
                           class="text-sm font-medium bg-green-600 text-white px-3 py-1 rounded-lg hover:bg-green-700">
                            Registrarse
                        </a>
                    </div>
                @endguest

            </div>
        </div>
    </header>

    <!-- MAIN -->
    <main class="flex-grow p-6">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white shadow-inner text-center text-gray-500 text-sm py-4">
        &copy; {{ date('Y') }} Biblioteca Virtual
    </footer>

</div>

<!-- Script sidebar móvil -->
<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const openBtn = document.getElementById('open-sidebar');
    const closeBtn = document.getElementById('close-sidebar');

    openBtn.addEventListener('click', () => {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    });

    const closeSidebar = () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    };

    closeBtn.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);
</script>

</body>
</html>
