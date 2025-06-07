<?php

namespace Database\Seeders;

use App\Models\QuoteProvider;
use Illuminate\Database\Seeder;

class QuoteProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $providers = [
            ['nombre' => 'Bet365', 'descripcion' => 'Casa de apuestas reconocida a nivel mundial'],
            ['nombre' => 'William Hill', 'descripcion' => 'Casa de apuestas de origen británico con amplia trayectoria'],
            ['nombre' => 'Codere', 'descripcion' => 'Casa de apuestas de origen español'],
            ['nombre' => '888Sport', 'descripcion' => 'Casa de apuestas líder en el mercado europeo'],
            ['nombre' => 'Betfair', 'descripcion' => 'Casa de apuestas con modelo de intercambio de apuestas'],
        ];

        foreach ($providers as $provider) {
            QuoteProvider::create($provider);
        }
    }
}
