<?php

namespace Database\Seeders;

use App\Models\OwnCompany;
use Illuminate\Database\Seeder;

class OwnCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'representante_legal' => 'Juan Pérez',
                'tipo_documento_id' => 1,
                'documento_gerente' => '12345678',
                'partida_registral' => 'PR-001',
                'oficina_registral' => 'Oficina Central Lima',
                'fecha_constitucion' => '2015-06-12',
                'estado_empresa' => 'activa',
                'fecha_cierre' => null,
                'nro_acciones_total' => 1000,
                'correo_empresa' => 'contacto@empresa1.com',
                'password' => 'password123',
                'tipo_control' => 'tributario',
                'dato_extra_tipo_entidad_id' => 9
            ],
            [
                'representante_legal' => 'María Gómez',
                'tipo_documento_id' => 2,
                'documento_gerente' => '20105478963',
                'partida_registral' => 'PR-002',
                'oficina_registral' => 'Oficina Regional Arequipa',
                'fecha_constitucion' => '2018-03-22',
                'estado_empresa' => 'activa',
                'fecha_cierre' => null,
                'nro_acciones_total' => 2000,
                'correo_empresa' => 'contacto@empresa2.com',
                'password' => 'password456',
                'tipo_control' => 'tributario',
                'dato_extra_tipo_entidad_id' => 10
            ],
        ];

        foreach ($data as $item) {
            OwnCompany::create($item);
        }
    }
}
