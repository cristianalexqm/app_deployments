<?php

namespace Database\Seeders;

use App\Models\MobileOperator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MobileOperatorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['cod' => 'Mov', 'operador' => 'Movistar', 'estado' => 1],
            ['cod' => 'Ent', 'operador' => 'Entel', 'estado' => 1],
            ['cod' => 'Bit', 'operador' => 'Bitel', 'estado' => 1],
            ['cod' => 'Clar', 'operador' => 'Claro', 'estado' => 1],
        ];

        foreach ($data as $item) {
            MobileOperator::create($item);
        }
    }
}
