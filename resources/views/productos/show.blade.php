{{-- resources/views/productos/show.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $producto->nombre }} - MiTienda</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
@if (session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    });
</script>
@endif

@if (session('error'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'error',
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    });
</script>
@endif


<body class="bg-gray-100 font-sans">

    <x-navbar />

    <div class="max-w-7xl mx-auto px-4 py-8 space-y-8 mt-[10rem] md:mt-[8rem]">
        <!-- Información principal y fotos -->
        <div class="bg-white rounded-2xl shadow p-6 flex flex-col md:flex-row gap-6">
            <!-- Imagen principal -->
            <div class="md:w-1/2 flex items-center justify-center bg-gray-100 rounded-xl p-4">
                @if($producto->fotos->isNotEmpty())
                <img src="{{ asset($producto->fotos->first()->ruta_archivo) }}"
                    alt="{{ $producto->nombre }}"
                    class="max-h-96 max-w-full object-contain rounded-xl shadow">
                @else
                <div class="h-96 w-full flex items-center justify-center bg-gray-200 rounded-xl">
                    <span class="text-gray-500 text-sm">Sin imagen</span>
                </div>
                @endif
            </div>

            <!-- Información del producto -->
            <div class="md:w-1/2 flex flex-col gap-3">
                <h1 class="text-4xl font-bold text-gray-800">{{ $producto->nombre }}</h1>
                <p class="text-gray-600">Marca: <span class="font-medium">{{ $producto->marca }}</span></p>
                @if($producto->categoria)
                <p class="text-gray-600">Categoría: <span class="font-medium">{{ $producto->categoria->nombre }}</span></p>
                @endif

                @if($producto->especificaciones)
                <div class="text-gray-700">
                    <h2 class="font-semibold mb-1">Especificaciones:</h2>
                    <p>{{ $producto->especificaciones }}</p>
                </div>
                @endif

                @if($producto->garantia)
                <p class="text-green-600 font-medium">Garantía: {{ $producto->garantia }}</p>
                @endif

                <p class="text-3xl font-bold text-indigo-600">${{ number_format($producto->precio, 2) }}</p>

                @if($producto->fecha_lanzamiento)
                <p class="text-xs text-gray-400">
                    Lanzado: {{ \Carbon\Carbon::parse($producto->fecha_lanzamiento)->format('d/m/Y') }}
                </p>
                @endif

                <form method="POST" action="">
                    @csrf
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-lg font-medium mt-4">
                        Agregar al Carrito
                    </button>
                </form>

                <a href="{{ route('productos.index') }}"
                    class="text-gray-700 hover:text-indigo-600 mt-4 inline-block">← Volver al catálogo</a>
            </div>
        </div>

        <!-- Detalle extendido del producto -->
        @if($producto->detalle)
        <div class="mt-8 bg-white rounded-3xl shadow-lg p-8 border border-gray-200">

            <!-- Resumen del producto -->
            @if($producto->detalle->resumen)
            <section class="mb-8 flex items-start gap-4">
                <div class="flex-shrink-0">
                    <!-- Icono de información -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 110 20 10 10 0 010-20z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Resumen del producto</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $producto->detalle->resumen }}</p>
                </div>
            </section>
            @endif

            <!-- Características destacadas -->
            @if($producto->detalle->caracteristicas)
            <section class="mb-8 flex items-start gap-4">
                <div class="flex-shrink-0">
                    <!-- Icono de check -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Características destacadas</h2>
                    <ul class="list-disc list-inside text-gray-700 leading-relaxed space-y-1">
                        @foreach(explode("\n", $producto->detalle->caracteristicas) as $caracteristica)
                        <li class="hover:text-indigo-600 transition-colors">{{ $caracteristica }}</li>
                        @endforeach
                    </ul>
                </div>
            </section>
            @endif

            <!-- Especificaciones detalladas -->
            @if($producto->detalle->especificaciones)
            <section class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <!-- Icono de cog/engranaje -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 019.75 3zM12 7.5v9m0 3h.75a.75.75 0 00.75-.75v-1.5a.75.75 0 00-1.5 0v1.5A.75.75 0 0012 19.5zm0-12h.75a.75.75 0 00.75-.75v-1.5a.75.75 0 00-1.5 0v1.5a.75.75 0 00.75.75z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Especificaciones detalladas</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $producto->detalle->especificaciones }}</p>
                </div>
            </section>
            @endif

        </div>
        @endif


        <!-- Reseñas del producto -->
        <div class="mt-8 bg-white rounded-3xl shadow-lg p-8 border border-gray-200 max-w-7xl mx-auto space-y-8">

            <h2 class="text-3xl font-bold text-gray-800 text-center mb-6">Reseñas de usuarios</h2>

            <!-- Lista de reseñas -->
            @if($producto->resenas->isNotEmpty())
            @foreach($producto->resenas as $resena)
            <div class="flex items-start gap-4 mb-2">
                <!-- Avatar con iniciales -->
                <img src="https://ui-avatars.com/api/?name={{ urlencode($resena->user->name ?? 'Usuario') }}&background=random&color=fff&size=64&rounded=true"
                    alt="avatar"
                    class="w-12 h-12 rounded-full border border-gray-300 shadow-sm">

                <!-- Contenido -->
                <div class="flex-1">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $resena->user->name ?? 'Usuario' }}</h3>
                        @if($resena->rating)
                        <span class="text-yellow-400 font-medium">⭐ {{ $resena->rating }}/5</span>
                        @endif
                    </div>
                    <p class="text-gray-700 mt-1">{{ $resena->contenido }}</p>
                </div>
            </div>

            @endforeach
            @else
            <p class="text-gray-500 text-center">Aún no hay reseñas para este producto.</p>
            @endif

            <!-- Formulario para agregar reseña -->
            <div class="mt-6 bg-gray-50 rounded-2xl p-6 border border-gray-200 shadow-inner">
                @auth
                <form action="{{ route('resenas.store', $producto) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="contenido" class="block text-sm font-medium text-gray-700">Tu reseña</label>
                        <textarea id="contenido" name="contenido" rows="4"
                            class="mt-1 block w-full border border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3 placeholder-gray-400"
                            placeholder="Escribe tu opinión aquí..." required></textarea>
                    </div>
                    <div>
                        <label for="rating" class="block text-sm font-medium text-gray-700">Calificación</label>
                        <select id="rating" name="rating"
                            class="mt-1 block w-32 border border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
                            <option value="">Selecciona</option>
                            @for($i=1; $i<=5; $i++)
                                <option value="{{ $i }}">{{ $i }} ⭐</option>
                                @endfor
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-xl font-medium transition">
                            Agregar reseña
                        </button>
                    </div>
                </form>
                @else
                <p class="text-gray-500 text-center text-sm">
                    Para agregar una reseña, debes
                    <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline">registrarte</a>
                    o
                    <a href="{{ route('login') }}" class="text-indigo-600 font-medium hover:underline">iniciar sesión</a>.
                </p>
                @endauth
            </div>

        </div>



    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>