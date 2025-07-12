<?php

namespace Database\Seeders;

use App\Models\BettingHouseCurrency;
use Illuminate\Database\Seeder;

class BettingHouseCurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['casa_de_apuesta_id' => 1, 'moneda_id' => 1, 'estado' => 'activo'],
            ['casa_de_apuesta_id' => 1, 'moneda_id' => 2, 'estado' => 'activo'],
            ['casa_de_apuesta_id' => 1, 'moneda_id' => 3, 'estado' => 'activo'],

            ['casa_de_apuesta_id' => 2, 'moneda_id' => 2, 'estado' => 'activo'],
            ['casa_de_apuesta_id' => 2, 'moneda_id' => 3, 'estado' => 'activo'],
            
            ['casa_de_apuesta_id' => 3, 'moneda_id' => 1, 'estado' => 'activo'],
            ['casa_de_apuesta_id' => 3, 'moneda_id' => 3, 'estado' => 'activo'],
            ['casa_de_apuesta_id' => 3, 'moneda_id' => 5, 'estado' => 'activo'],
            
            ['casa_de_apuesta_id' => 4, 'moneda_id' => 4, 'estado' => 'activo'],
            ['casa_de_apuesta_id' => 4, 'moneda_id' => 5, 'estado' => 'activo'],
        ];

        foreach ($data as $item) {
            BettingHouseCurrency::create($item);
        }
    }
}