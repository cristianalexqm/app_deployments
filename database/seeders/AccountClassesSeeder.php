<?php

namespace Database\Seeders;

use App\Models\AccountClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['cod' => 'AHOR', 'tipo_clase_cuenta' => 'Ahorro', 'estado' => 1],
            ['cod' => 'CRED', 'tipo_clase_cuenta' => 'Crédito', 'estado' => 1],
            ['cod' => 'DIGT', 'tipo_clase_cuenta' => 'Digital', 'estado' => 1],
            ['cod' => 'CORR', 'tipo_clase_cuenta' => 'Corriente', 'estado' => 1],
        ];

        foreach ($data as $item) {
            AccountClass::create($item);
        }
    }
}
