<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");
        }

        $users = $query->paginate(10);

        return view('usuarios.index', compact('users'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación manual
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'role'  => 'required|in:admin,standard',
            'password' => 'required|string|min:6|confirmed', // "confirmed" valida password_confirmation
        ]);

        if ($validator->fails()) {
            // Redirige de vuelta con errores en SweetAlert
            return redirect()->back()
                ->with('error', 'Por favor corrige los errores en el formulario.')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Crea el usuario
            User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'role'     => $request->role,
                'password' => Hash::make($request->password), // cifrado de password
            ]);

            return redirect()->route('users.index')
                ->with('success', 'Usuario creado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ocurrió un error al crear el usuario.')
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
    public function edit(User $user)
    {
        return view('usuarios.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validación manual
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,standard',
        ]);

        if ($validator->fails()) {
            // Redirige de vuelta con errores en SweetAlert
            return redirect()->back()
                ->with('error', 'Por favor corrige los errores en el formulario.')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $user->update($request->only('name', 'email', 'role'));

            return redirect()->route('users.index')
                ->with('success', 'Usuario actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ocurrió un error al actualizar el usuario.')
                ->withInput();
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();

            // Mensaje de éxito con SweetAlert
            return redirect()->route('users.index')
                ->with('success', 'Usuario eliminado correctamente.');
        } catch (\Exception $e) {
            // Mensaje de error con SweetAlert
            return redirect()->route('users.index')
                ->with('error', 'Ocurrió un error al eliminar el usuario.');
        }
    }
}
