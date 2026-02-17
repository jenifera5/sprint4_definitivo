<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loan;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PrestamoSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            // 1️⃣ Préstamo activo
            Loan::create([
                'id_usuario' => 2,
                'id_libro' => 1,
                'fecha_prestamo' => Carbon::now()->subDays(10),
                'fecha_devolucion' => Carbon::now()->addDays(20),
                'devuelto' => false
            ]);

            Book::find(1)?->decrement('disponibles');


            // 2️⃣ Préstamo activo
            Loan::create([
                'id_usuario' => 1,
                'id_libro' => 2,
                'fecha_prestamo' => Carbon::now()->subDays(5),
                'fecha_devolucion' => Carbon::now()->addDays(25),
                'devuelto' => false
            ]);

            Book::find(2)?->decrement('disponibles');


            // 3️⃣ Préstamo devuelto
            Loan::create([
                'id_usuario' => 3,
                'id_libro' => 1,
                'fecha_prestamo' => Carbon::now()->subDays(60),
                'fecha_devolucion' => Carbon::now()->subDays(30),
                'devuelto' => true
            ]);


            // 4️⃣ Préstamo devuelto
            Loan::create([
                'id_usuario' => 2,
                'id_libro' => 2,
                'fecha_prestamo' => Carbon::now()->subDays(45),
                'fecha_devolucion' => Carbon::now()->subDays(15),
                'devuelto' => true
            ]);


            // 5️⃣ Préstamo retrasado
            Loan::create([
                'id_usuario' => 4,
                'id_libro' => 2,
                'fecha_prestamo' => Carbon::now()->subDays(35),
                'fecha_devolucion' => Carbon::now()->subDays(5),
                'devuelto' => false
            ]);

            Book::find(2)?->decrement('disponibles');
        });

        echo "Préstamos creados correctamente\n";
    }
}
