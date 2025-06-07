<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['cod' => 'PEN', 'moneda' => 'Soles', 'naturaleza'=>'tangible', 'estado' => 1],
            ['cod' => 'USD', 'moneda' => 'Dólares', 'naturaleza'=>'tangible', 'estado' => 1],
            ['cod' => 'EUR', 'moneda' => 'Euros', 'naturaleza'=>'tangible', 'estado' => 1],
            ['cod' => 'USDT', 'moneda' => 'Usdt', 'naturaleza'=>'digital', 'estado' => 1],
            ['cod' => 'SHIB', 'moneda' => 'Shiba', 'naturaleza'=>'digital', 'estado' => 1],
        ];

        foreach ($data as $item) {
            Currency::create($item);
        }
    }
}
