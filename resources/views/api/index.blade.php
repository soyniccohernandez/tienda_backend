<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Documentación API - MiTienda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav class="flex text-gray-700 dark:text-gray-300 text-sm pb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 3.22l7 6V18a1 1 0 0 1-1 1h-4v-5H8v5H4a1 1 0 0 1-1-1V9.22l7-6z" />
                            </svg>
                            Inicio
                        </a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 0 1 0-1.414L10.586 10 7.293 6.707a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414l-4 4a1 1 0 0 1-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </li>
                    <li><span class="text-gray-500 dark:text-gray-400">Documentación API</span></li>
                </ol>
            </nav>

            <div class="space-y-8">

                <!-- Introducción -->
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3">Introducción</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        Esta documentación describe la API RESTful de la aplicación de comercio electrónico <strong>MiTienda</strong>, construida en Laravel. La API permite la gestión de <strong>productos, categorías y reseñas</strong>. Este proyecto se realizó como un ejercicio de aprendizaje para la clase de <em>Desarrollo de Software Web Backend Virtual</em>.
                    </p>
                </div>

                <!-- Categorías -->
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3">Categorías</h3>

                    <table class="w-full text-left text-gray-700 dark:text-gray-300">
                        <thead class="bg-gray-100 dark:bg-gray-700 rounded-t-xl">
                            <tr>
                                <th class="px-4 py-2">Acción</th>
                                <th class="px-4 py-2">Método</th>
                                <th class="px-4 py-2">URL</th>
                                <th class="px-4 py-2">Body / Parámetros</th>
                                <th class="px-4 py-2">Respuesta</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            <tr>
                                <td class="px-4 py-2">Listar categorías</td>
                                <td class="px-4 py-2">GET</td>
                                <td class="px-4 py-2"><code>/api/categorias</code></td>
                                <td class="px-4 py-2">Opcional: <code>search</code></td>
                                <td class="px-4 py-2">JSON con categorías paginadas</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2">Crear categoría</td>
                                <td class="px-4 py-2">POST</td>
                                <td class="px-4 py-2"><code>/api/categorias</code></td>
                                <td class="px-4 py-2"><code>{ "nombre": "Electrónica", "descripcion": "Gadgets" }</code></td>
                                <td class="px-4 py-2">JSON con la categoría creada</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2">Ver categoría</td>
                                <td class="px-4 py-2">GET</td>
                                <td class="px-4 py-2"><code>/api/categorias/{id}</code></td>
                                <td class="px-4 py-2">-</td>
                                <td class="px-4 py-2">JSON con la categoría</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2">Actualizar categoría</td>
                                <td class="px-4 py-2">PUT</td>
                                <td class="px-4 py-2"><code>/api/categorias/{id}</code></td>
                                <td class="px-4 py-2"><code>{ "nombre": "Electrónica y Tecnología", "descripcion": "Productos electrónicos" }</code></td>
                                <td class="px-4 py-2">JSON con categoría actualizada</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2">Eliminar categoría</td>
                                <td class="px-4 py-2">DELETE</td>
                                <td class="px-4 py-2"><code>/api/categorias/{id}</code></td>
                                <td class="px-4 py-2">-</td>
                                <td class="px-4 py-2">JSON confirmando eliminación</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Productos -->
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3">Productos</h3>
                    <table class="w-full text-left text-gray-700 dark:text-gray-300">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2">Acción</th>
                                <th class="px-4 py-2">Método</th>
                                <th class="px-4 py-2">URL</th>
                                <th class="px-4 py-2">Body / Parámetros</th>
                                <th class="px-4 py-2">Respuesta</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            <tr>
                                <td class="px-4 py-2">Listar productos</td>
                                <td class="px-4 py-2">GET</td>
                                <td class="px-4 py-2"><code>/api/productos</code></td>
                                <td class="px-4 py-2">Opcionales: <code>q</code>, <code>categoria_id</code>, <code>orden_precio</code></td>
                                <td class="px-4 py-2">JSON con productos y promociones</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2">Ver producto</td>
                                <td class="px-4 py-2">GET</td>
                                <td class="px-4 py-2"><code>/api/productos/{id}</code></td>
                                <td class="px-4 py-2">-</td>
                                <td class="px-4 py-2">JSON con detalles, fotos y reseñas</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2">Crear reseña</td>
                                <td class="px-4 py-2">POST</td>
                                <td class="px-4 py-2"><code>/api/productos/{id}/resenas</code></td>
                                <td class="px-4 py-2"><code>{ "contenido": "Excelente producto", "rating": 5 }</code></td>
                                <td class="px-4 py-2">JSON confirmando reseña</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2">CRUD Backend</td>
                                <td class="px-4 py-2">GET, POST, PUT, DELETE</td>
                                <td class="px-4 py-2"><code>/api/productosback</code></td>
                                <td class="px-4 py-2">Dependiendo del método</td>
                                <td class="px-4 py-2">JSON con productos creados, actualizados o eliminados</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Reseñas -->
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3">Reseñas</h3>
                    <table class="w-full text-left text-gray-700 dark:text-gray-300">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2">Acción</th>
                                <th class="px-4 py-2">Método</th>
                                <th class="px-4 py-2">URL</th>
                                <th class="px-4 py-2">Body / Parámetros</th>
                                <th class="px-4 py-2">Respuesta</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            <tr>
                                <td class="px-4 py-2">Agregar reseña</td>
                                <td class="px-4 py-2">POST</td>
                                <td class="px-4 py-2"><code>/api/productos/{id}/resenas</code></td>
                                <td class="px-4 py-2"><code>{ "contenido": "Muy útil", "rating": 4 }</code></td>
                                <td class="px-4 py-2">JSON confirmando creación de la reseña</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>