<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder {
    public function run() {
        $data = [
            ['nombre' => 'Empleado'],
            ['nombre' => 'Proveedor'],
            ['nombre' => 'Cliente'],
            ['nombre' => 'Asociado Trading'],
            ['nombre' => 'Empresa Propia'],
            ['nombre' => 'Accionista'],
        ];

        foreach ($data as $item) {
            Type::create($item);
        }
    }
}
