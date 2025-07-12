<?php

namespace Database\Seeders;

use App\Models\AssociateTypeAssociate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssociateTypeAssociateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'asociado_id' => 1,
                'tipo_asociado_id' => 1,
                'code_tipo' => 'AC0001',
                'code_sistema' => 'AC-SandraT',
                'estado' => 'activo',
                'fecha_alta' => '2020-01-15',
                'fecha_baja' => null
            ],
            [
                'asociado_id' => 1,
                'tipo_asociado_id' => 2,
                'code_tipo' => 'AA0001',
                'code_sistema' => 'AA-SandraT',
                'estado' => 'activo',
                'fecha_alta' => '2019-05-20',
                'fecha_baja' => null
            ],
            [
                'asociado_id' => 1,
                'tipo_asociado_id' => 3,
                'code_tipo' => 'AD0001',
                'code_sistema' => 'AD-SandraT',
                'estado' => 'activo',
                'fecha_alta' => '2021-08-10',
                'fecha_baja' => null
            ],
        ];

        foreach ($data as $item) {
            AssociateTypeAssociate::create($item);
        }
    }
}
