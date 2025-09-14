<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
</head>

<body class="bg-gray-100 font-sans">
    
    <x-navbar />
    <!-- Agregar un margen superior para que no quede tapado por el navbar fijo -->
    <div class="h-16"></div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    <div class="max-w-7xl mx-auto px-4 py-8 mt-[4rem]">
        <!-- Carrousel de promociones -->
        <div class="max-w-7xl mx-auto mb-8 mt-5">

            <div x-data="carousel()" class="relative bg-white rounded-2xl shadow overflow-hidden">
                <template x-for="(producto, index) in productos" :key="producto.id">
                    <div x-show="current === index" class="flex flex-col items-center p-4">

                        <!-- Imagen -->
                        <div class="h-40 w-full flex items-center justify-center bg-white">
                            <template x-if="producto.foto">
                                <img :src="producto.foto"
                                    :alt="producto.nombre"
                                    class="max-h-40 max-w-full object-contain">
                            </template>
                            <template x-if="!producto.foto">
                                <div class="bg-gray-200 h-40 w-full flex items-center justify-center">
                                    <span class="text-gray-500 text-sm">Sin imagen</span>
                                </div>
                            </template>
                        </div>

                        <!-- Nombre y precio -->
                        <h3 class="text-lg font-semibold text-gray-800 mt-2" x-text="producto.nombre"></h3>
                        <p class="text-indigo-600 font-bold" x-text="'$' + parseFloat(producto.precio).toFixed(2)"></p>
                    </div>
                </template>

                <!-- Botones -->
                <button @click="prev()" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-2 py-1 rounded-full">&larr;</button>
                <button @click="next()" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-2 py-1 rounded-full">&rarr;</button>
            </div>
        </div>

        <!-- Buscador + Filtro + Orden -->
        <form method="GET" action="{{ route('productos.index') }}" class="mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">

                <!-- Columna 1: Input búsqueda -->
                <input type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Buscar por nombre o marca..."
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                <!-- Columna 2: Select categoría -->
                <select name="categoria_id"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                    @endforeach
                </select>

                <!-- Columna 3: Select orden por precio -->
                <select name="orden_precio"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Ordenar por precio</option>
                    <option value="asc" {{ request('orden_precio') == 'asc' ? 'selected' : '' }}>Menor a Mayor</option>
                    <option value="desc" {{ request('orden_precio') == 'desc' ? 'selected' : '' }}>Mayor a Menor</option>
                </select>

                <!-- Columna 4: Botones mitad-mitad -->
                <div class="grid grid-cols-2 gap-2">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
                        Buscar
                    </button>
                    <a href="{{ route('productos.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition text-center">
                        Limpiar
                    </a>
                </div>
            </div>
        </form>



        <!-- Grid de productos -->
        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @forelse($productos as $producto)
            <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden flex flex-col">
                <!-- Imagen real -->
                @if($producto->fotos->isNotEmpty())
                <div class="h-40 w-full flex items-center justify-center bg-white">
                    <img src="{{ asset($producto->fotos->first()->ruta_archivo) }}"
                        alt="{{ $producto->nombre }}"
                        class="max-h-40 max-w-full object-contain">
                </div>
                @else
                <div class="bg-gray-200 h-40 flex items-center justify-center">
                    <span class="text-gray-500 text-sm">Sin imagen</span>
                </div>
                @endif

                <div class="p-4 flex-1 flex flex-col">
                    <!-- Nombre -->
                    <h2 class="text-lg font-semibold text-gray-800 truncate">{{ $producto->nombre }}</h2>

                    <!-- Marca -->
                    <p class="text-sm text-gray-500 mb-2">Marca: {{ $producto->marca }}</p>

                    <!-- Categoría -->
                    @if($producto->categoria)
                    <p class="text-sm text-gray-500 mb-2">Categoría: {{ $producto->categoria->nombre }}</p>
                    @endif

                    <!-- Especificaciones -->
                    @if($producto->especificaciones)
                    <p class="text-sm text-gray-600 mb-3 line-clamp-3">
                        {{ $producto->especificaciones }}
                    </p>
                    @endif

                    <!-- Garantía -->
                    @if($producto->garantia)
                    <p class="text-xs text-green-600 font-medium mb-2">Garantía: {{ $producto->garantia }}</p>
                    @endif

                    <!-- Precio -->
                    <p class="text-xl font-bold text-indigo-600 mb-3">${{ number_format($producto->precio, 2) }}</p>

                    <!-- Fecha lanzamiento -->
                    @if($producto->fecha_lanzamiento)
                    <p class="text-xs text-gray-400 mb-3">
                        Lanzado: {{ \Carbon\Carbon::parse($producto->fecha_lanzamiento)->format('d/m/Y') }}
                    </p>
                    @endif

                    <!-- Botón -->
                    <div class="mt-auto">
                        <a href="{{ route('productos.show', $producto->id) }}"
                            class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg font-medium transition">
                            Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full flex flex-col items-center justify-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2h-3V3H9v2H6a2 2 0 00-2 2v6m16 0v6a2 2 0 01-2 2h-3v2H9v-2H6a2 2 0 01-2-2v-6h16z" />
                </svg>
                <p class="text-gray-500 text-lg font-medium">No se encontraron productos</p>
            </div>
            @endforelse
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function carousel() {
            return {
                current: 0,
                productos: @json($promos), // los productos aleatorios desde el controlador
                init() {
                    // Cambio automático cada 3 segundos (3000 ms)
                    setInterval(() => {
                        this.next();
                    }, 3000);
                },
                prev() {
                    this.current = (this.current === 0) ? this.productos.length - 1 : this.current - 1;
                },
                next() {
                    this.current = (this.current === this.productos.length - 1) ? 0 : this.current + 1;
                }
            }
        }
    </script>
</body>

</html>