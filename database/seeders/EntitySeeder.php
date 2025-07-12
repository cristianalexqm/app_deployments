<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Entity;

class EntitySeeder extends Seeder {
    public function run() {
        $data = [
            [
                'tipo_documento_id' => 1, 'documento' => '12345678', 'nombre_razon_social' => 'Mario Duran', 'direccion' => 'Av. Siempre Viva 123',
                'pais' => 'Perú', 'departamento' => 'Lima', 'provincia' => 'Lima', 'distrito' => 'Miraflores', 'descripcion' => null, 'foto_usuario' => null,
            ],
            [
                'tipo_documento_id' => 2, 'documento' => '20501234567', 'nombre_razon_social' => 'Empresa XYZ SAC', 'direccion' => 'Calle Comercio 456',
                'pais' => 'Perú', 'departamento' => 'Arequipa', 'provincia' => 'Arequipa', 'distrito' => 'Cercado', 'descripcion' => null, 'foto_usuario' => null,
            ],
            [
                'tipo_documento_id' => 1, 'documento' => '87654321', 'nombre_razon_social' => 'Sandra Torres', 'direccion' => 'Av. Siempre Muerta 205',
                'pais' => 'Perú', 'departamento' => 'Trujillo', 'provincia' => 'Trujillo', 'distrito' => 'Cervantes', 'descripcion' => null, 'foto_usuario' => null,
            ],
            [
                'tipo_documento_id' => 2, 'documento' => '20501234561', 'nombre_razon_social' => 'Empresa ABC SAC', 'direccion' => 'Calle Tarso 987',
                'pais' => 'Perú', 'departamento' => 'Tacna', 'provincia' => 'Tacna', 'distrito' => 'Casas', 'descripcion' => null, 'foto_usuario' => null,
            ],
        ];

        foreach ($data as $item) {
            Entity::create($item);
        }
    }
}
