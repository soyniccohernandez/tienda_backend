<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Card Usuarios -->
                <a href="{{ route('users.index') }}"
                    class="block bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6 text-center hover:shadow-xl transition">
                    <div class="text-indigo-600 dark:text-indigo-400 text-4xl mb-3">👥</div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Usuarios</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                        Gestiona y administra los usuarios del sistema.
                    </p>
                </a>

                <!-- Card Categorías -->
                <a href="{{ route('categorias.index') }}"
                    class="block bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6 text-center hover:shadow-xl transition">
                    <div class="text-yellow-600 dark:text-yellow-400 text-4xl mb-3">🗂️</div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Categorías</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                        Organiza y administra las categorías de productos.
                    </p>
                </a>

                <!-- Card Productos -->
                <a href="{{ route('productosback.index') }}" 
                    class="block bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6 text-center hover:shadow-xl transition">
                    <div class="text-green-600 dark:text-green-400 text-4xl mb-3">📦</div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Productos</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                        Administra los productos y sus detalles.
                    </p>
                </a>

                <!-- Card API -->
                <a href="#"
                    class="block bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6 text-center hover:shadow-xl transition">
                    <div class="text-purple-600 dark:text-purple-400 text-4xl mb-3">🔗</div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">API</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                        Accede a integraciones y servicios del sistema.
                    </p>
                </a>

            </div>
        </div>
    </div>






</x-app-layout>