<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AfpCommissionType;

class AfpCommissionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['code' => 'FLUJO', 'nombre' => 'Comisión Flujo'],
            ['code' => 'MIXTA', 'nombre' => 'Comisión Mixta'],
        ];

        foreach ($data as $item) {
            AfpCommissionType::create($item);
        }
    }
}
