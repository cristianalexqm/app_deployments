<?php

namespace Database\Seeders;

use App\Models\AccountTypeBanks;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountTypesBanksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['cod' => 'BANC', 'tipo_cuenta' => 'Banco', 'estado' => 1],
            ['cod' => 'CRIP', 'tipo_cuenta' => 'Cripto', 'estado' => 1],
            ['cod' => 'EFEC', 'tipo_cuenta' => 'Efectivo', 'estado' => 1],
            ['cod' => 'BILL', 'tipo_cuenta' => 'Billetera', 'estado' => 1],
            ['cod' => 'LINC', 'tipo_cuenta' => 'Linea Credito', 'estado' => 1],
        ];

        foreach ($data as $item) {
            AccountTypeBanks::create($item);
        }
    }
}
