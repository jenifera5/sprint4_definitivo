<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index()
    {
        $prestamos = Loan::with('user', 'book')->orderBy('created_at', 'desc')->get();
        return view('prestamos.index', compact('prestamos'));
    }

    public function create()
    {
        $usuarios = User::all();
        // Solo libros con copias disponibles
        $libros = Book::where('disponibles', '>', 0)->get();
        
        return view('prestamos.create', compact('usuarios', 'libros'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id',
            'id_libro' => 'required|exists:libros,id',
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion' => 'required|date|after:fecha_prestamo',
        ], [
            'id_usuario.required' => 'Debes seleccionar un usuario',
            'id_libro.required' => 'Debes seleccionar un libro',
            'fecha_prestamo.required' => 'La fecha de préstamo es obligatoria',
            'fecha_devolucion.required' => 'La fecha de devolución es obligatoria',
            'fecha_devolucion.after' => 'La fecha de devolución debe ser posterior a la de préstamo',
        ]);

        // Verificar que el libro tenga copias disponibles
        $libro =Book::find($request->id_libro);
        
        if ($libro->disponibles <= 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'No hay copias disponibles de este libro');
        }

        // Crear préstamo y reducir disponibilidad en una transacción
        DB::transaction(function () use ($request, $libro) {
            Loan::create([
                'id_usuario' => $request->id_usuario,
                'id_libro' => $request->id_libro,
                'fecha_prestamo' => $request->fecha_prestamo,
                'fecha_devolucion' => $request->fecha_devolucion,
                'devuelto' => false, // Por defecto no devuelto
            ]);

            // Reducir copias disponibles
            $libro->decrement('disponibles');
        });

        return redirect()->route('prestamos.index')
            ->with('success', 'Préstamo creado correctamente');
    }

    public function show(Loan $prestamo)
    {
        $prestamo->load('user', 'book');
        return view('prestamos.show', compact('prestamo'));
    }

    public function edit(Loan $prestamo)
    {
        $prestamo->load('user', 'book');
        $usuarios = User::all();
        $libros = Book::all();

        return view('prestamos.edit', compact('prestamo', 'usuarios', 'libros'));
    }

    public function update(Request $request, Loan $prestamo)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id',
            'id_libro' => 'required|exists:libros,id',
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion' => 'required|date|after:fecha_prestamo',
            'devuelto' => 'nullable|boolean',
        ], [
            'fecha_devolucion.after' => 'La fecha de devolución debe ser posterior a la de préstamo',
        ]);

        // Si se marca como devuelto y antes no lo estaba, incrementar disponibles
        $devueltoAntes = $prestamo->devuelto;
        $devueltoAhora = $request->has('devuelto') ? (bool)$request->devuelto : false;

        DB::transaction(function () use ($request, $prestamo, $devueltoAntes, $devueltoAhora) {
            $prestamo->update([
                'id_usuario' => $request->id_usuario,
                'id_libro' => $request->id_libro,
                'fecha_prestamo' => $request->fecha_prestamo,
                'fecha_devolucion' => $request->fecha_devolucion,
                'devuelto' => $devueltoAhora,
            ]);

            // Si se devuelve el libro, incrementar disponibilidad
            if (!$devueltoAntes && $devueltoAhora) {
                $prestamo->libro->increment('disponibles');
            }
            // Si se "desmarca" como devuelto, decrementar disponibilidad
            elseif ($devueltoAntes && !$devueltoAhora) {
                $prestamo->libro->decrement('disponibles');
            }
        });

        return redirect()->route('prestamos.index')
            ->with('success', 'Préstamo actualizado correctamente');
    }

    public function destroy(Loan $prestamo)
    {
        DB::transaction(function () use ($prestamo) {
            // Si el préstamo no está devuelto, devolver la copia al inventario
            if (!$prestamo->devuelto) {
                $prestamo->libro->increment('disponibles');
            }
            
            $prestamo->delete();
        });

        return redirect()->route('prestamos.index')
            ->with('success', 'Préstamo eliminado correctamente');
    }

    /**
     * Marcar préstamo como devuelto
     */
    public function marcarDevuelto(Loan $prestamo)
    {
        if ($prestamo->devuelto) {
            return redirect()->back()
                ->with('error', 'Este préstamo ya está marcado como devuelto');
        }

        DB::transaction(function () use ($prestamo) {
            $prestamo->update(['devuelto' => true]);
            $prestamo->libro->increment('disponibles');
        });

        return redirect()->route('prestamos.index')
            ->with('success', 'Libro devuelto correctamente. Copias disponibles actualizadas.');
    }
}
































































