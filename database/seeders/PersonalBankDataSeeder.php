<?php

namespace Database\Seeders;

use App\Models\PersonalBankData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonalBankDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nombre_persona' => 'Juan Pérez',
                'celular' => '987654321',
                'id_operador_movil' => 1,
                'correo' => 'juan.perez@example.com',
                'password' => 'password123',
                'nombre_papa' => 'Carlos Pérez',
                'nombre_mama' => 'María Gómez',
                'lugar_nacimiento' => 'Lima',
                'fecha_nacimiento' => '1990-05-10',
                'edad_actual' => 33,
                'otros_datos' => 'Cliente VIP',
                'ficha_reniec' => null
            ],
            [
                'nombre_persona' => 'María López',
                'celular' => '956123789',
                'id_operador_movil' => 2,
                'correo' => 'maria.lopez@example.com',
                'password' => 'clave456',
                'nombre_papa' => 'Roberto López',
                'nombre_mama' => 'Luisa Fernández',
                'lugar_nacimiento' => 'Arequipa',
                'fecha_nacimiento' => '1985-08-25',
                'edad_actual' => 38,
                'otros_datos' => null,
                'ficha_reniec' => 'ABC123456'
            ],
        ];

        foreach ($data as $item) {
            PersonalBankData::create($item);
        }
    }
}
