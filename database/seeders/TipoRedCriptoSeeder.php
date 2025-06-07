<?php

namespace Database\Seeders;

use App\Models\TipoRedCripto;
use Illuminate\Database\Seeder;

class TipoRedCriptoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['cod' => 'BSC - BET20', 'red' => 'Binance Smart Chain', 'estado' => 1,],
            ['cod' => 'ETH - ERC20', 'red' => 'ETHEREUM', 'estado' => 1,],
            ['cod' => 'TXR - TRC20', 'red' => 'TRON', 'estado' => 1,],
            ['cod' => 'SOL - SOL20', 'red' => 'SOLANA', 'estado' => 1,],
        ];

        foreach ($data as $item) {
            TipoRedCripto::create($item);
        }
    }
}
