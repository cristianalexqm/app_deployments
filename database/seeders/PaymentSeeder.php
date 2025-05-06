<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = ['pending', 'processing', 'success', 'failed'];

        for ($i = 0; $i < 20; $i++) {
            Payment::create([
                'email' => fake()->unique()->safeEmail(),
                'amount' => fake()->randomFloat(2, 10, 500),
                'state' => $states[array_rand($states)],
            ]);
        }
    }
}
