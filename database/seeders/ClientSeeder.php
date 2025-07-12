<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'tipo_banco_id' => 1,
                'cuenta_bancaria' => '1234567890',
                'aval' => 'Garantía emitida por Banco Nacional',
                'dato_extra_tipo_entidad_id' => 7
            ],
        ];

        foreach ($data as $item) {
            Client::create($item);
        }
    }
}
