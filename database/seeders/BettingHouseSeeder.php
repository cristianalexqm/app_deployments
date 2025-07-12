<?php

namespace Database\Seeders;

use App\Models\BettingHouse;
use Illuminate\Database\Seeder;

class BettingHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'foto' => null,
                'descripcion' => 'Casa de apuesta líder en el mercado con excelentes cuotas y variedad de deportes.',
                'nombre' => 'BetWinner',
                'proveedor_cuota_id' => 2,
                'link_casa_apuesta' => 'https://www.betwinner.com',
                'pais' => 'Reino Unido',
                'estado' => 'activo',
                'fecha_alta' => '2021-01-15',
                'fecha_baja' => null,
                'verificacion' => 'Certificado por la autoridad reguladora de apuestas en Reino Unido.'
            ],
            [
                'foto' => null,
                'descripcion' => 'Casa de apuesta reconocida por sus rápidas transacciones y seguridad.',
                'nombre' => 'Bet365',
                'proveedor_cuota_id' => 1,
                'link_casa_apuesta' => 'https://www.bet365.com',
                'pais' => 'Peru',
                'estado' => 'activo',
                'fecha_alta' => '2020-05-10',
                'fecha_baja' => null,
                'verificacion' => 'Regulada por la Pervian Gambling Commission.'
            ],
            [
                'foto' => null,
                'descripcion' => 'Casa de apuesta con las mejores cuotas en eventos internacionales.',
                'nombre' => '1xBet',
                'proveedor_cuota_id' => 4,
                'link_casa_apuesta' => 'https://www.1xbet.com',
                'pais' => 'Rusia',
                'estado' => 'activo',
                'fecha_alta' => '2018-08-22',
                'fecha_baja' => null,
                'verificacion' => 'Certificado por la comisión de apuestas de Rusia.'
            ],
            [
                'foto' => null,
                'descripcion' => 'Casa de apuesta popular en América Latina con bonos atractivos.',
                'nombre' => 'Codere',
                'proveedor_cuota_id' => 3,
                'link_casa_apuesta' => 'https://www.codere.com',
                'pais' => 'México',
                'estado' => 'activo',
                'fecha_alta' => '2019-03-12',
                'fecha_baja' => null,
                'verificacion' => 'Certificado por la comisión de juegos de México.'
            ],
        ];

        foreach ($data as $item) {
            BettingHouse::create($item);
        }
    }
}
