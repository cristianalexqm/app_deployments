<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'tipo_trabajador_id' => 1,
                'cargo' => 'Gerente',
                'moneda_id' => 1,
                'reembolso_basico' => 1200.50,
                'cups_essalud' => 'ESS123456',
                'hijos_asignados_familia' => 2,
                'tipo_banco_sueldo' => 1,
                'cuenta_banco' => '1234567890',
                'cci_banco' => '12345678901234567890',
                'eleccion_fondo' => 'AFP',
                'tipo_afp_id' => 1,
                'tipo_comision_afp_id' => 1,
                'dato_extra_tipo_entidad_id' => 1
            ],
            [
                'tipo_trabajador_id' => 2,
                'cargo' => 'Asistente',
                'moneda_id' => 2,
                'reembolso_basico' => 800.00,
                'cups_essalud' => 'ESS654321',
                'hijos_asignados_familia' => 1,
                'tipo_banco_sueldo' => 2,
                'cuenta_banco' => '0987654321',
                'cci_banco' => '09876543210987654321',
                'eleccion_fondo' => 'ONP',
                'tipo_afp_id' => null,
                'tipo_comision_afp_id' => null,
                'dato_extra_tipo_entidad_id' => 2
            ],
            [
                'tipo_trabajador_id' => 1,
                'cargo' => 'Contador',
                'moneda_id' => 1,
                'reembolso_basico' => 1500.75,
                'cups_essalud' => 'ESS987654',
                'hijos_asignados_familia' => 0,
                'tipo_banco_sueldo' => 3,
                'cuenta_banco' => '4561237890',
                'cci_banco' => '45612378901234567890',
                'eleccion_fondo' => 'AFP',
                'tipo_afp_id' => 2,
                'tipo_comision_afp_id' => 2,
                'dato_extra_tipo_entidad_id' => 3
            ],
            [
                'tipo_trabajador_id' => 2,
                'cargo' => 'Analista',
                'moneda_id' => 2,
                'reembolso_basico' => 950.25,
                'cups_essalud' => null,
                'hijos_asignados_familia' => 3,
                'tipo_banco_sueldo' => 4,
                'cuenta_banco' => '7894561230',
                'cci_banco' => '78945612301234567890',
                'eleccion_fondo' => 'ONP',
                'tipo_afp_id' => null,
                'tipo_comision_afp_id' => null,
                'dato_extra_tipo_entidad_id' => 4
            ],
        ];

        foreach ($data as $item) {
            Employee::create($item);
        }
    }
}
