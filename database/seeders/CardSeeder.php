<?php

namespace Database\Seeders;

use App\Models\Card;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'numero_tarjeta' => '4111111111111111',
                'cvv' => '123',
                'fecha_expiracion' => '2027-12-31',
                'clave_cajero' => '4321',
                'id_tipo_tarjeta' => 1
            ],
            [
                'numero_tarjeta' => '5500000000000004',
                'cvv' => '456',
                'fecha_expiracion' => '2028-11-30',
                'clave_cajero' => '9876',
                'id_tipo_tarjeta' => 2
            ],
        ];

        foreach ($data as $item) {
            Card::create($item);
        }
    }
}
