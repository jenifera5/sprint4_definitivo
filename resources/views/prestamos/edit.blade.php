@extends('layouts.app')
@section('title', 'Editar Préstamo')
@section('page-title', 'Editar Préstamo')
@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">✏️ Editar Préstamo</h1>
    
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
            <ul class="list-disc list-inside text-red-700 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('prestamos.update', $prestamo->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-user text-blue-600 mr-1"></i> Usuario *
            </label>
            <select name="id_usuario" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500" required>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ $prestamo->id_usuario == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
