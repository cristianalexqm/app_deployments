<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EntityType;

class EntityTypeSeeder extends Seeder {
    public function run() {
        $data = [
            ['code' => 'EM0001', 'tipo_id' => 1, 'entidad_id' => 1, 'estado' => 'activo', 'fecha_alta' => '2020-10-04', 'fecha_baja' => null], // 
            ['code' => 'EM0002', 'tipo_id' => 1, 'entidad_id' => 2, 'estado' => 'activo', 'fecha_alta' => '2020-10-04', 'fecha_baja' => null], // 
            ['code' => 'EM0003', 'tipo_id' => 1, 'entidad_id' => 3, 'estado' => 'activo', 'fecha_alta' => '2020-10-04', 'fecha_baja' => null], // 
            ['code' => 'EM0004', 'tipo_id' => 1, 'entidad_id' => 4, 'estado' => 'activo', 'fecha_alta' => '2020-10-04', 'fecha_baja' => null], // 

            ['code' => 'PR0001', 'tipo_id' => 2, 'entidad_id' => 1, 'estado' => 'activo', 'fecha_alta' => '2020-10-04', 'fecha_baja' => null], // 
            ['code' => 'PR0002', 'tipo_id' => 2, 'entidad_id' => 4, 'estado' => 'activo', 'fecha_alta' => '2020-10-04', 'fecha_baja' => null], // 

            ['code' => 'CL0001', 'tipo_id' => 3, 'entidad_id' => 1, 'estado' => 'activo', 'fecha_alta' => '2020-10-04', 'fecha_baja' => null], // 

            ['code' => 'AT0001', 'tipo_id' => 4, 'entidad_id' => 3, 'estado' => 'activo', 'fecha_alta' => '2020-10-04', 'fecha_baja' => null], // 

            ['code' => 'EP0001', 'tipo_id' => 5, 'entidad_id' => 2, 'estado' => 'activo', 'fecha_alta' => '2020-10-04', 'fecha_baja' => null], // 
            ['code' => 'EP0002', 'tipo_id' => 5, 'entidad_id' => 4, 'estado' => 'activo', 'fecha_alta' => '2020-10-04', 'fecha_baja' => null], // 

            ['code' => 'AC0001', 'tipo_id' => 6, 'entidad_id' => 1, 'estado' => 'activo', 'fecha_alta' => '2020-10-04', 'fecha_baja' => null], // 
            ['code' => 'AC0002', 'tipo_id' => 6, 'entidad_id' => 4, 'estado' => 'activo', 'fecha_alta' => '2020-10-04', 'fecha_baja' => null], // 
        ];

        foreach ($data as $item) {
            EntityType::create($item);
        }
    }
}
