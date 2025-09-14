<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Categoria::query();

        // Búsqueda por nombre o descripción
        if ($request->filled('search')) {
            $query->where('nombre', 'like', "%{$request->search}%")
                ->orWhere('descripcion', 'like', "%{$request->search}%");
        }

        // Paginación (10 por página)
        $categorias = $query->paginate(10);

        // Retorna la vista con los datos
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación manual
        $validator = Validator::make($request->all(), [
            'nombre'      => 'required|string|max:255|unique:categorias,nombre',
            'descripcion' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            // Redirige de vuelta con errores en SweetAlert
            return redirect()->back()
                ->with('error', 'Por favor corrige los errores en el formulario.')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Crea la categoría
            Categoria::create([
                'nombre'      => $request->nombre,
                'descripcion' => $request->descripcion,
            ]);

            return redirect()->route('categorias.index')
                ->with('success', 'Categoría creada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ocurrió un error al crear la categoría.')
                ->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        // Validación manual
        $validator = Validator::make($request->all(), [
            'nombre'      => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            // Redirige de vuelta con errores en SweetAlert
            return redirect()->back()
                ->with('error', 'Por favor corrige los errores en el formulario.')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Actualiza la categoría
            $categoria->update($request->only('nombre', 'descripcion'));

            return redirect()->route('categorias.index')
                ->with('success', 'Categoría actualizada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ocurrió un error al actualizar la categoría.')
                ->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        try {
            $categoria->delete();

            // Mensaje de éxito con SweetAlert
            return redirect()->route('categorias.index')
                ->with('success', 'Categoría eliminada correctamente.');
        } catch (\Exception $e) {
            // Mensaje de error con SweetAlert
            return redirect()->route('categorias.index')
                ->with('error', 'Ocurrió un error al eliminar la categoría.');
        }
    }
}
