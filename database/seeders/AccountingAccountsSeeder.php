<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountingAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🔹 Insertando los elementos principales (PADRES - Nivel "Balance")
        $parentsData = [
            ['code' => '10', 'name' => 'Caja y bancos', 'description' => 'Cuentas de caja y bancos', 'level' => 'Balance', 'category_id' => 1],
            ['code' => '11', 'name' => 'Inversiones al valor razonable y disponibles para la venta', 'description' => 'Inversiones con valor razonable', 'level' => 'Balance', 'category_id' => 1],
            ['code' => '12', 'name' => 'Cuentas por cobrar comerciales - Terceros', 'description' => 'Cuentas comerciales por cobrar', 'level' => 'Balance', 'category_id' => 1],
            ['code' => '14', 'name' => 'Cuentas por cobrar al personal, accionistas y directores', 'description' => 'Cuentas por cobrar a directivos', 'level' => 'Balance', 'category_id' => 1],
            ['code' => '20', 'name' => 'Mercaderías', 'description' => 'Inventarios de mercaderías', 'level' => 'Balance', 'category_id' => 1],
            ['code' => '30', 'name' => 'Inversiones mobiliarias', 'description' => 'Inversiones en activos financieros', 'level' => 'Balance', 'category_id' => 1],
            ['code' => '40', 'name' => 'Tributos y aportes al sistema de pensiones y de salud por pagar', 'description' => 'Obligaciones tributarias', 'level' => 'Balance', 'category_id' => 2],
            ['code' => '41', 'name' => 'Remuneraciones y participaciones por pagar', 'description' => 'Obligaciones laborales', 'level' => 'Balance', 'category_id' => 2],
            ['code' => '50', 'name' => 'Capital', 'description' => 'Capital contable', 'level' => 'Balance', 'category_id' => 3],
            ['code' => '55', 'name' => 'Resultados no realizados', 'description' => 'Diferencias de revaluación', 'level' => 'Balance', 'category_id' => 3],
        ];

        DB::table('accounting_accounts')->upsert($parentsData, ['code']);

        // 🔹 Obtener IDs de cuentas padres
        $parents = DB::table('accounting_accounts')->whereIn('code', array_column($parentsData, 'code'))->get()->keyBy('code');

        // 🔹 Insertando Subcuentas (Nivel "Sub-Cuenta")
        $subaccountsData = [
            ['code' => '10.1', 'name' => 'Caja', 'description' => 'Dinero en efectivo', 'level' => 'Sub-Cuenta', 'category_id' => 1, 'parent_id' => $parents['10']->id],
            ['code' => '10.2', 'name' => 'Fondos fijos', 'description' => 'Fondos para gastos menores', 'level' => 'Sub-Cuenta', 'category_id' => 1, 'parent_id' => $parents['10']->id],
            ['code' => '10.3', 'name' => 'Efectivo en tránsito', 'description' => 'Efectivo en movimiento', 'level' => 'Sub-Cuenta', 'category_id' => 1, 'parent_id' => $parents['10']->id],
            ['code' => '10.4', 'name' => 'Cta cte en Inst Finan', 'description' => 'Cta cte en Inst Finan', 'level' => 'Sub-Cuenta', 'category_id' => 1, 'parent_id' => $parents['10']->id],
        ];





        DB::table('accounting_accounts')->upsert($subaccountsData, ['code']);

        // 🔹 Obtener IDs de subcuentas DESPUÉS de insertarlas
        // 🔹 Obtener IDs de subcuentas
        $subaccounts = DB::table('accounting_accounts')->whereIn('code', array_column($subaccountsData, 'code'))->get()->keyBy('code');

        // 🔹 FASE 1: Insertar las sub-subcuentas directas
        $subSubaccountsDirectData = [
            ['code' => '10.4.1', 'name' => 'Ctas Empresa Propias', 'description' => 'Cuentas propias', 'level' => 'Sub-Cuenta', 'category_id' => 1, 'parent_id' => $subaccounts['10.4']->id ?? null],
            ['code' => '10.4.2', 'name' => 'Ctas Ahorro Clientes y Afiliados', 'description' => 'Cuentas de ahorro', 'level' => 'Sub-Cuenta', 'category_id' => 1, 'parent_id' => $subaccounts['10.4']->id ?? null],
        ];
        



        DB::table('accounting_accounts')->upsert($subSubaccountsDirectData, ['code']);

        // 🔹 Obtener IDs de las sub-subcuentas directas después de insertarlas
        $subSubaccounts = DB::table('accounting_accounts')->whereIn('code', array_column($subSubaccountsDirectData, 'code'))->get()->keyBy('code');

        // 🔹 FASE 2: Insertar las sub-subcuentas anidadas
        $subSubaccountsNestedData = [
            ['code' => '10.4.2.1', 'name' => 'Ctas de Tipo Asociado Tributario', 'description' => 'Tributario', 'level' => 'Sub-Cuenta', 'category_id' => 1, 'parent_id' => $subSubaccounts['10.4.2']->id ?? null],
            ['code' => '10.4.2.2', 'name' => 'Ctas de Tipo Asociado Financieros', 'description' => 'Financieros', 'level' => 'Sub-Cuenta', 'category_id' => 1, 'parent_id' => $subSubaccounts['10.4.2']->id ?? null],
            // ['code' => '10.4.2.2.1', 'name' => 'Clientes Emp Mundo Cripto', 'description' => 'Clientes Empresa Mundo Cripto', 'level' => 'Sub-Cuenta', 'category_id' => 1, 'parent_id' => $subSubaccounts['10.4.2.2']->id ?? null],
        ];

        DB::table('accounting_accounts')->upsert($subSubaccountsNestedData, ['code']);
    }
}
