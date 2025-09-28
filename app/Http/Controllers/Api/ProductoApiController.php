<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoApiController extends Controller
{
    /**
     * Listar productos con filtros
     */
    public function index(Request $request)
    {
        // Iniciar la query incluyendo las fotos y la categoría
        $query = Producto::with(['fotos', 'categoria']);

        // Filtro de búsqueda por nombre o marca
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('marca', 'like', "%{$search}%");
            });
        }

        // Filtro por categoría
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        // Orden por precio
        if ($request->filled('orden_precio')) {
            $query->orderBy('precio', $request->orden_precio); // asc o desc
        }

        // Obtener productos filtrados
        $productos = $query->get();

        // Productos aleatorios para carrousel (ej: 5)
        $promos = Producto::with('fotos')->inRandomOrder()->take(5)->get()->map(function ($producto) {
            return [
                'id'     => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'foto'   => $producto->fotos->first()
                                ? asset($producto->fotos->first()->ruta_archivo)
                                : null,
            ];
        });

        return response()->json([
            'productos'  => $productos,
            'promos'     => $promos,
            'categorias' => Categoria::all(),
        ], 200);
    }

    /**
     * Mostrar un producto específico con sus relaciones
     */
    public function show(Producto $producto)
    {
        $producto->load('categoria', 'fotos', 'resenas', 'detalle');

        return response()->json([
            'producto'          => $producto,
            'reseña_principal'  => $producto->resenas->first(),
        ], 200);
    }
}
