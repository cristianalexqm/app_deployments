<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentType;

class DocumentTypeSeeder extends Seeder {
    public function run() {
        $data = [
            ['code' => 'DNI', 'nombre' => 'Documento Nacional de Identidad'],
            ['code' => 'RUC', 'nombre' => 'Registro Único de Contribuyentes'],
            ['code' => 'PAS', 'nombre' => 'Pasaporte'],
            ['code' => 'CE', 'nombre' => 'Carnet de Extranjería'],
        ];

        foreach ($data as $item) {
            DocumentType::create($item);
        }
    }
}
