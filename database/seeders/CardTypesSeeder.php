<?php

namespace Database\Seeders;

use App\Models\CardType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['cod' => 'VISA', 'emisor' => 'Visa', 'estado' => 1],
            ['cod' => 'MAST', 'emisor' => 'Mastercard', 'estado' => 1],
            ['cod' => 'AMEX', 'emisor' => 'Amex', 'estado' => 1],
        ];
          
        foreach ($data as $item) {
            CardType::create($item);
        }
    }
}
