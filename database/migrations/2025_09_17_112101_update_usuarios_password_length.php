<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Cambiar el campo password de 45 a 255 caracteres para bcrypt
            $table->string('password', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // NO REVERTIR - mantener 255 para evitar errores
        // Si realmente necesitas revertir, primero borra todos los usuarios
        // Schema::table('usuarios', function (Blueprint $table) {
        //     $table->string('password', 45)->change();
        // });
    }
};




































































