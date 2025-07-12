<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusAssignmentAssociatedCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Activo',
                'description' => 'Activo',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Desactivado',
                'description' => 'Desactivado',
                'created_at' => now(),
                'updated_at' => now()
            ]
            // [
            //     'name' => 'C-Vencido',
            //     'description' => 'Vencido',
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ],
            // [
            //     'name' => 'C-Liquidado',
            //     'description' => 'Liquidado',
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ]
        ];

        // 🔥 Insertar datos en la tabla
        DB::table('status_assignment_associated_companies')->insert($data);
    }
}
