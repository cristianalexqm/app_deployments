<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder {
    public function run() {
        $data = [
            [
                'persona_contacto' => 'Carlos Ramírez', 'celular_contacto' => '999888777', 'correo_contacto' => 'contacto@empresa.com', 'tipo_empresa' => 'juridica', 'entidad_id' => 2,
            ],
            [
                'persona_contacto' => 'Ruben De La Barrera', 'celular_contacto' => '987444111', 'correo_contacto' => 'envios@empresa.com', 'tipo_empresa' => 'juridica', 'entidad_id' => 4,
            ],
        ];

        foreach ($data as $item) {
            Company::create($item);
        }
    }
}
