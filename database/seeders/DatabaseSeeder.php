<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            //Catalogo
            CardTypesSeeder::class,
            MobileOperatorsSeeder::class,
            CurrenciesSeeder::class,
            AccountClassesSeeder::class,
            AccountTypesBanksSeeder::class,
            BankTypesSeeder::class,
            DocumentTypeSeeder::class,
            QuoteProviderSeeder::class,
            TipoRedCriptoSeeder::class,

            PaymentSeeder::class,

            //Entidades
            AfpTypeSeeder::class,
            AfpCommissionTypeSeeder::class,
            WorkerTypeSeeder::class,
        ]);
    }
}
