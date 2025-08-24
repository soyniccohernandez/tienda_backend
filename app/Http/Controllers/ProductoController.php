<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Resena;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
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

        // Traer todas las categorías para el select
        $categorias = Categoria::all();

        // Productos aleatorios para carrousel (puedes limitar la cantidad)
        // Controlador
        $promos = Producto::with('fotos')->inRandomOrder()->take(5)->get()->map(function ($producto) {
            return [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'foto' => $producto->fotos->first() ? asset($producto->fotos->first()->ruta_archivo) : null,
            ];
        });

        return view('welcome', compact('productos', 'categorias', 'promos'));
    }

    public function show(Producto $producto)
    {
        // Cargar relaciones necesarias
        $producto->load('categoria', 'fotos', 'resenas', 'detalle');

        // Tomamos la primera reseña como la principal
        $reseñaPrincipal = $producto->resenas->first();

        // Puedes acceder al detalle desde $producto->detalle en la vista
        return view('productos.show', compact('producto', 'reseñaPrincipal'));
    }

    
}
