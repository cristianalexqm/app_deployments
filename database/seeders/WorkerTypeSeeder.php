<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkerType;

class WorkerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['code' => 'GER', 'nombre' => 'Gerencia'],
            ['code' => 'ADM', 'nombre' => 'Administración'],
            ['code' => 'TRD', 'nombre' => 'Trader Deportivo'],
        ];

        foreach ($data as $item) {
            WorkerType::create($item);
        }
    }
}
