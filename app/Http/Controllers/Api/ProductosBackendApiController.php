<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductosBackendApiController extends Controller
{
    /**
     * Listado de productos (con búsqueda y paginación).
     */
    public function index(Request $request)
    {
        $query = Producto::query();

        if ($request->filled('search')) {
            $query->where('nombre', 'like', "%{$request->search}%")
                ->orWhere('marca', 'like', "%{$request->search}%")
                ->orWhere('especificaciones', 'like', "%{$request->search}%");
        }

        $productos = $query->with('categoria')->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $productos
        ]);
    }

    /**
     * Crear producto.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'            => 'required|string|max:255|unique:productos,nombre',
            'marca'             => 'required|string|max:255',
            'especificaciones'  => 'nullable|string',
            'garantia'          => 'nullable|string|max:255',
            'precio'            => 'required|numeric|min:0',
            'fecha_lanzamiento' => 'nullable|date',
            'categoria_id'      => 'required|exists:categorias,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $producto = Producto::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Producto creado correctamente.',
            'data' => $producto
        ], 201);
    }

    /**
     * Mostrar producto.
     */
    public function show($id)
    {
        $producto = Producto::with('categoria')->find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $producto
        ]);
    }

    /**
     * Actualizar producto.
     */
    public function update(Request $request, Producto $producto)
    {
        $validator = Validator::make($request->all(), [
            'nombre'           => 'required|string|max:255|unique:productos,nombre,' . $producto->id,
            'marca'            => 'required|string|max:255',
            'especificaciones' => 'nullable|string',
            'garantia'         => 'nullable|string|max:255',
            'precio'           => 'required|numeric|min:0',
            'fecha_lanzamiento'=> 'nullable|date',
            'categoria_id'     => 'required|exists:categorias,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $producto->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado correctamente.',
            'data' => $producto
        ]);
    }

    /**
     * Eliminar producto.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado correctamente.'
        ]);
    }
}
