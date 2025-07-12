<?php

namespace Database\Seeders;

use App\Models\AssociateEmail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssociateEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'correo' => 'correo1@empresa.com',
                'password' => 'password123',
                'asociado_id' => 1
            ],
            [
                'correo' => 'correo2@empresa.com',
                'password' => 'password456',
                'asociado_id' => 1
            ],
            [
                'correo' => 'correo3@empresa.com',
                'password' => 'password789',
                'asociado_id' => 1
            ],
        ];

        foreach ($data as $item) {
            AssociateEmail::create($item);
        }
    }
}
