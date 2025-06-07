<?php

namespace Database\Seeders;

use App\Models\BankType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['cod' => 'BCP', 'tipo_banco' => 'Banco de Crédito del Perú', 'tipo_recurso' => 'FIAT', 'tipos_cuentas_bancos_id' => '1', 'estado' => 1],
            ['cod' => 'INTB', 'tipo_banco' => 'Interbank', 'tipo_recurso' => 'FIAT', 'tipos_cuentas_bancos_id' => '1', 'estado' => 1],
            ['cod' => 'BBVA', 'tipo_banco' => 'BBVA', 'tipo_recurso' => 'FIAT', 'tipos_cuentas_bancos_id' => '1', 'estado' => 1],
            ['cod' => 'SCOT', 'tipo_banco' => 'Scotiabank', 'tipo_recurso' => 'FIAT', 'tipos_cuentas_bancos_id' => '1', 'estado' => 1],
            ['cod' => 'MIB', 'tipo_banco' => 'Mibanco', 'tipo_recurso' => 'FIAT', 'tipos_cuentas_bancos_id' => '1', 'estado' => 1],
            ['cod' => 'PICH', 'tipo_banco' => 'Banco Pichincha', 'tipo_recurso' => 'FIAT', 'tipos_cuentas_bancos_id' => '1', 'estado' => 1],

            ['cod' => 'BINC', 'tipo_banco' => 'Binance', 'tipo_recurso' => 'CRIPTO', 'tipos_cuentas_bancos_id' => '2', 'estado' => 1],
            ['cod' => 'MMAX', 'tipo_banco' => 'Metamask', 'tipo_recurso' => 'CRIPTO', 'tipos_cuentas_bancos_id' => '2', 'estado' => 1],

            ['cod' => 'CAJA', 'tipo_banco' => 'Caja Fuerte', 'tipo_recurso' => 'FIAT', 'tipos_cuentas_bancos_id' => '3', 'estado' => 1],

            ['cod' => 'SKLL', 'tipo_banco' => 'Skrill', 'tipo_recurso' => 'BILLETERA', 'tipos_cuentas_bancos_id' => '4', 'estado' => 1],
            ['cod' => 'APAY', 'tipo_banco' => 'AstroPay', 'tipo_recurso' => 'BILLETERA', 'tipos_cuentas_bancos_id' => '4', 'estado' => 1],
            ['cod' => 'PAYP', 'tipo_banco' => 'Paypal', 'tipo_recurso' => 'BILLETERA', 'tipos_cuentas_bancos_id' => '4', 'estado' => 1]
        ];

        foreach ($data as $item) {
            BankType::create($item);
        }
    }
}
