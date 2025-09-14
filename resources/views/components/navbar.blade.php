<!-- Banner + Navbar unidos -->
<nav class="fixed top-0 left-0 w-full z-50 shadow-lg">
    <!-- Banner rojo -->
    <div class="bg-red-600 text-white text-center px-4 py-2">
        <p class="text-sm sm:text-base font-semibold leading-tight">
            Proyecto desarrollado únicamente por
            <span class="underline">Erick Nicolás Hernández Díaz</span> y
            <span class="underline">Jose Hermes Rocha Morales</span>,
            para la clase de <span class="italic">DESARROLLO DE SOFTWARE WEB BACK-END</span>
            – <span class="font-bold">Profundización - Actividad 04</span>
        </p>
        <p class="text-xs mt-1 opacity-80">
            🚫 Se prohíbe el uso de este recurso fuera de este ámbito. Cualquier uso NO está autorizado.
        </p>
    </div>


    <!-- Navbar blanco -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo + Link Administración -->
                <div class="flex items-center space-x-4">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="text-2xl font-bold text-indigo-600">MiTienda</a>

                    <!-- Link Administración solo para admin -->
                    @auth
                    @if(auth()->user()->role === 'admin')
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Administración') }}
                    </x-nav-link>
                    @endif
                    @endauth
                </div>

                <!-- Carrito y Auth -->
                <div class="flex items-center space-x-4">
                    <!-- Carrito solo si no es admin -->
                    @auth
                    @if(auth()->user()->role !== 'admin')
                    <a href="" class="relative text-gray-700 hover:text-indigo-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4"></path>
                            <circle cx="7" cy="21" r="1"></circle>
                            <circle cx="17" cy="21" r="1"></circle>
                        </svg>
                        @if(session('carrito'))
                        <span
                            class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full px-1">{{ count(session('carrito')) }}</span>
                        @endif
                    </a>
                    @endif
                    @endauth

                    <!-- Mi Cuenta / Auth -->
                    @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center text-gray-700 hover:text-indigo-600 transition focus:outline-none">
                            <span class="mr-2">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6"></path>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-lg py-2 z-10">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Perfil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Cerrar sesión</button>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="flex space-x-2">
                        <a href="{{ route('login') }}"
                            class="text-gray-700 hover:text-indigo-600 font-medium transition">Iniciar sesión</a>
                        <a href="{{ route('register') }}"
                            class="text-gray-700 hover:text-indigo-600 font-medium transition">Registrarse</a>
                    </div>
                    @endauth
                </div>
            </div>

        </div>
    </div>
</nav>