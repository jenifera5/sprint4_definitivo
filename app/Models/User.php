<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
       use HasFactory;
    protected $table = 'usuarios';

    protected $fillable = ['nombre', 'email', 'password'];

    // Un usuario tiene muchos préstamos
    public function prestamos()
    {
        return $this->hasMany(Loan::class, 'id_usuario');
    }
}
