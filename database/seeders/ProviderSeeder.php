<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
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
                'dato_extra_tipo_entidad_id' => 5
            ],
            [
                'tipo_banco_id' => 2,
                'cuenta_bancaria' => '0987654321',
                'aval' => 'Aval firmado por entidad reconocida',
                'dato_extra_tipo_entidad_id' => 6
            ],
        ];

        foreach ($data as $item) {
            Provider::create($item);
        }
    }
}
