<?php

namespace Database\Seeders;

use App\Models\AssociateType;
use Illuminate\Database\Seeder;

class AssociateTypeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['code' => 'AC','nombre' => 'Asociado Contrato', 'tipo_control' => 'tributario'],
            ['code' => 'AA','nombre' => 'Asociado Afiliado', 'tipo_control' => 'financiero'],
            ['code' => 'AD','nombre' => 'Asociado DNI', 'tipo_control' => 'financiero'],
        ];

        foreach ($data as $item) {
            AssociateType::create($item);
        }
    }
}
