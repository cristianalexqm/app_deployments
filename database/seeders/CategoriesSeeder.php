<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Activo'],
            ['name' => 'Pasivo'],
            ['name' => 'Patrimonio'],
            ['name' => 'Gastos por naturaleza '],
            ['name' => 'Ingresos por naturaleza'],
            ['name' => 'Saldos intermediarios de gestión y determinación de los resultados del ejercicio'],
            ['name' => 'Costos de Producción y Gastos por Función'],
            ['name' => 'Orden'],
        ]);
    }
}
