<?php

namespace Database\Seeders;

use App\Models\Associate;
use Illuminate\Database\Seeder;

class AssociateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nick_apodo' => 'SandraT',
                'telefono' => '987654321',
                'correo_recuperacion' => 'correo.recu@example.com',
                'dato_extra_tipo_entidad_id' => 8
            ],
        ];

        foreach ($data as $item) {
            Associate::create($item);
        }
    }
}
