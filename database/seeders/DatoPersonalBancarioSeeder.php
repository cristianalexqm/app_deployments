<?php

namespace Database\Seeders;

use App\Models\DatosPersonalesBancarios;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatoPersonalBancarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['tipo_entidad_id' => 8],
            ['tipo_entidad_id' => 9],
            ['tipo_entidad_id' => 10],
        ];

        foreach ($data as $item) {
            DatosPersonalesBancarios::create($item);
        }
    }
}
