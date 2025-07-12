<?php

namespace Database\Seeders;

use App\Models\BettingHouseCurrencyAssociateType;
use Illuminate\Database\Seeder;

class BettingHouseCurrencyAssociateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['tipo_asociado_id' => 1, 'casa_de_apuesta_moneda_id' => 1, 'estado' => 'activo'],
            ['tipo_asociado_id' => 2, 'casa_de_apuesta_moneda_id' => 1, 'estado' => 'activo'],

            ['tipo_asociado_id' => 3, 'casa_de_apuesta_moneda_id' => 2, 'estado' => 'activo'],

            //------------------------------------------------------------------------------//

            ['tipo_asociado_id' => 2, 'casa_de_apuesta_moneda_id' => 4, 'estado' => 'activo'],

            ['tipo_asociado_id' => 1, 'casa_de_apuesta_moneda_id' => 5, 'estado' => 'activo'],
            ['tipo_asociado_id' => 3, 'casa_de_apuesta_moneda_id' => 5, 'estado' => 'activo'],

            //------------------------------------------------------------------------------//

            ['tipo_asociado_id' => 2, 'casa_de_apuesta_moneda_id' => 6, 'estado' => 'activo'],

            ['tipo_asociado_id' => 1, 'casa_de_apuesta_moneda_id' => 7, 'estado' => 'activo'],
            ['tipo_asociado_id' => 2, 'casa_de_apuesta_moneda_id' => 7, 'estado' => 'activo'],
            
            ['tipo_asociado_id' => 3, 'casa_de_apuesta_moneda_id' => 8, 'estado' => 'activo'],

            //------------------------------------------------------------------------------//

            ['tipo_asociado_id' => 1, 'casa_de_apuesta_moneda_id' => 9, 'estado' => 'activo'],
            ['tipo_asociado_id' => 2, 'casa_de_apuesta_moneda_id' => 9, 'estado' => 'activo'],

            ['tipo_asociado_id' => 2, 'casa_de_apuesta_moneda_id' => 10, 'estado' => 'activo'],
            ['tipo_asociado_id' => 3, 'casa_de_apuesta_moneda_id' => 10, 'estado' => 'activo'],
        ];

        foreach ($data as $item) {
            BettingHouseCurrencyAssociateType::create($item);
        }
    }
}
