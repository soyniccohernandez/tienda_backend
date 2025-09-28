<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaApiController extends Controller
{
    /**
     * Listar categorías con búsqueda y paginación
     */
    public function index(Request $request)
    {
        $query = Categoria::query();

        // Búsqueda por nombre o descripción
        if ($request->filled('search')) {
            $query->where('nombre', 'like', "%{$request->search}%")
                  ->orWhere('descripcion', 'like', "%{$request->search}%");
        }

        // Paginación (10 por página por defecto)
        $categorias = $query->paginate(10);

        return response()->json($categorias, 200);
    }

    /**
     * Crear una nueva categoría
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'      => 'required|string|max:255|unique:categorias,nombre',
            'descripcion' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación.',
                'errors'  => $validator->errors()
            ], 422);
        }

        $categoria = Categoria::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return response()->json([
            'message'   => 'Categoría creada correctamente.',
            'categoria' => $categoria
        ], 201);
    }

    /**
     * Mostrar una categoría específica
     */
    public function show(Categoria $categoria)
    {
        return response()->json($categoria, 200);
    }

    /**
     * Actualizar una categoría
     */
    public function update(Request $request, Categoria $categoria)
    {
        $validator = Validator::make($request->all(), [
            'nombre'      => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación.',
                'errors'  => $validator->errors()
            ], 422);
        }

        $categoria->update($request->only('nombre', 'descripcion'));

        return response()->json([
            'message'   => 'Categoría actualizada correctamente.',
            'categoria' => $categoria
        ], 200);
    }

    /**
     * Eliminar una categoría
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return response()->json([
            'message' => 'Categoría eliminada correctamente.'
        ], 200);
    }
}
