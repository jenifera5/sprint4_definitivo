<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
     Route::resource('usuarios', UserController::class);
    Route::resource('libros', BookController::class);
    Route::resource('categorias', CategoryController::class);
    Route::resource('prestamos', LoanController::class);

    Route::patch('prestamos/{prestamo}/devuelto', [LoanController::class, 'marcarDevuelto'])
        ->name('prestamos.marcar-devuelto');
});

require __DIR__.'/auth.php';
