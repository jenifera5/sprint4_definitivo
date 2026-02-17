<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    
    public function create()
    {
        return view('usuarios.create');
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email|max:255',
            'password' => 'required|string|min:8|confirmed', // Mínimo 8 caracteres + confirmación
        ], [
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'email.unique' => 'Este email ya está registrado',
        ]);

        User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password), // ENCRIPTAR contraseña
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado con éxito');
    }
   
    public function show(User $usuario)
    {
        return view('usuarios.show', compact('usuario'));
    }

   
    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    
    public function update(Request $request, User $usuario)
    {
        $rules = [
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id . '|max:255',
        ];

        // Solo validar contraseña si se proporciona
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules, [
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'email.unique' => 'Este email ya está registrado',
        ]);

        $data = [
            'nombre' => $request->nombre,
            'email' => $request->email,
        ];

        // Solo actualizar contraseña si se proporciona
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);
        
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }

    
    public function destroy(User $usuario)
    {
        // Verificar si tiene préstamos activos
        if ($usuario->prestamos()->exists()) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No se puede eliminar el usuario porque tiene préstamos asociados');
        }

        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }
}


































