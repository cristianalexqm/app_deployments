<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Person;

class PersonSeeder extends Seeder {
    public function run() {
        $data = [
            [
                'nombre_pila' => 'Mario', 'apellido_paterno' => 'Duran', 'apellido_materno' => 'Norris', 'ruc' => '10456789012', 'fecha_nacimiento' => '1990-05-15',
                'correo' => 'mario.duran@example.com', 'genero' => 'masculino', 'telefono' => '987654321', 'codigo_postal' => '10601', 'entidad_id' => 1,
            ],
            [
                'nombre_pila' => 'Sandra', 'apellido_paterno' => 'Torres', 'apellido_materno' => 'Soler', 'ruc' => '10456789014', 'fecha_nacimiento' => '1985-02-09',
                'correo' => 'sandra.torres@example.com', 'genero' => 'femenino', 'telefono' => '963258741', 'codigo_postal' => '14602', 'entidad_id' => 3,
            ],
        ];

        foreach ($data as $item) {
            Person::create($item);
        }
    }
}
