<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AfpType;

class AfpTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['code' => 'PRIMA', 'nombre' => 'Afp Prima'],
            ['code' => 'INTEGRA', 'nombre' => 'Afp Integra'],
            ['code' => 'HABITAT', 'nombre' => 'Afp Habitat'],
            ['code' => 'PROFUTURO', 'nombre' => 'Afp Profuturo'],
        ];

        foreach ($data as $item) {
            AfpType::create($item);
        }
    }
}
