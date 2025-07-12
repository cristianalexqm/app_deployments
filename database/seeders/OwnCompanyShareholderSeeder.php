<?php

namespace Database\Seeders;

use App\Models\ShareholderOwnCompany;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OwnCompanyShareholderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nro_acciones' => 500,
                'porcentaje_acciones' => 50.00,
                'fecha_desde' => '2015-06-12',
                'fecha_hasta' => null,
                'empresa_propia_id' => 1,
                'tipo_entidad_id' => 11
            ],
            [
                'nro_acciones' => 1000,
                'porcentaje_acciones' => 50.00,
                'fecha_desde' => '2018-03-22',
                'fecha_hasta' => null,
                'empresa_propia_id' => 2,
                'tipo_entidad_id' => 12
            ],
        ];

        foreach ($data as $item) {
            ShareholderOwnCompany::create($item);
        }
    }
}
