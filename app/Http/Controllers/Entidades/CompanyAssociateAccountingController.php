<?php

namespace App\Http\Controllers\Entidades;

use  App\Http\Controllers\Controller;
use App\Models\AccountingAccount;
use App\Models\Associate;
use App\Models\AssociateTypeAssociate;
use App\Models\BettingHouseCurrency;
use App\Models\CasaDeApuestaAsociadoAccounting;
use App\Models\CompanyAssociateAccounting;
use App\Models\OwnCompany;
use Illuminate\Http\Request;

class CompanyAssociateAccountingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Cargamos las relaciones para mostrar datos más descriptivos
        $relations = CompanyAssociateAccounting::with(['company', 'associateTypeAssociate', 'accountingAccount'])->get();
        // dd($relations->toArray());
        return view('company_associate_accounting.index', compact('relations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $asociados = Associate::with([
            'tiposAsociados.tipoAsociado',
            'tiposAsociados.companyAssociateAccounting.company'
        ])->findOrFail($id);
        
        // dd($asociados->toArray());

        $companies = OwnCompany::all();

        return view('entities_section.types.forms.asignar_empresa_asociado_trading', compact('companies', 'asociados'));
    }

    /**public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'own_company_id' => 'required|exists:empresa_propia,id',
            'associate_type_associate_id' => 'required|exists:asociado_tipo_asociado,id',
        ]);
        // dd($request->all());

        // extrae la id de own_company_id y associate_type_associate_id y lo almacena en una variable ----------
        $companyId = $request->input('own_company_id');
        $associateTypeAssociateId = $request->input('associate_type_associate_id');
        // dd($associateTypeAssociateId);

        // Obtener los datos relevantes
        $company = OwnCompany::findOrFail($companyId);
        $associateTypeAssociate = AssociateTypeAssociate::with('asociado', 'tipoAsociado')->findOrFail($associateTypeAssociateId);

        // dd($company->toArray());
        // dd($associateTypeAssociate->toArray());

        $associateName = $associateTypeAssociate->asociado->nick_apodo;
        $typeName = $associateTypeAssociate->tipoAsociado->nombre;

        // 🔥 Obtener TODAS las cuentas contables asociadas a la empresa
        // $baseAccounts = $company->accountingAccounts()->get();
        $baseAccounts = $company->accountingAccounts()->where('is_base', true)->get();


        if ($baseAccounts->isEmpty()) {
            return redirect()->back()->with('error', 'Esta empresa no tiene cuentas contables base asignadas.');
        }

        if ($baseAccounts->isNotEmpty()) {
            foreach ($baseAccounts as $baseAccount) {

                $existingAccount = AccountingAccount::where('own_company_id', $companyId)
                    ->where('parent_id', $baseAccount->id)
                    ->where('name', "{$associateName} - {$typeName} - {$baseAccount->name}")
                    ->first();

                if ($existingAccount) {
                    // 🚨 Si la cuenta ya existe, lanzar un mensaje de error
                    return redirect()->back()->with('error', "Esta empresa ya tiene una cuenta asociada a {$associateName} {$typeName}.");
                }

                if (!$existingAccount) {
                    $newAccount = AccountingAccount::create([
                        // 'code' => $this->generateAccountCode($companyId, $baseAccount->code),
                        'code' => $this->generateAccountCode($baseAccount),
                        'name' => "{$associateName} - {$typeName} - {$baseAccount->name}",
                        'description' => "Subcuenta generada automáticamente para {$associateName}",
                        'sports_trading' => $baseAccount->sports_trading,
                        'accounting_type' => $baseAccount->accounting_type,
                        'currencies_id' => $baseAccount->currencies_id,
                        // 'level' => $baseAccount->level,
                        'level' => 'Sub-Cuenta',
                        'category_id' => $baseAccount->category_id,
                        'parent_id' => $baseAccount->id,
                        'own_company_id' => $companyId,
                    ]);

                    // ✅ 3️⃣ ASOCIAR CUENTA CONTABLE A TRAVÉS DE company_associate_accounting
                    CompanyAssociateAccounting::create([
                        'own_company_id' => $companyId,
                        'associate_type_associate_id' => $associateTypeAssociateId,
                        'accounting_account_id' => $newAccount->id,
                    ]);
                }
                
            }
        }

        return redirect()->back()->with('success', 'Relación Empresa-Asociado-Cuenta creada con éxito');
    }**/

    //21-03-2025 10:26 am
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'own_company_id' => 'required|exists:empresa_propia,id',
            'associate_type_associate_id' => 'required|exists:asociado_tipo_asociado,id',
        ]);
        // dd($request->all());

        // extrae la id de own_company_id y associate_type_associate_id y lo almacena en una variable ----------
        $companyId = $request->input('own_company_id');
        $associateTypeAssociateId = $request->input('associate_type_associate_id');
        // dd($associateTypeAssociateId);

        // Obtener los datos relevantes
        $company = OwnCompany::findOrFail($companyId);
        $associateTypeAssociate = AssociateTypeAssociate::with('asociado', 'tipoAsociado')->findOrFail($associateTypeAssociateId);

        // dd($company->toArray());
        // dd($associateTypeAssociate->toArray());

        // $associateName = $associateTypeAssociate->asociado->nick_apodo;
        $associateName = $associateTypeAssociate->asociado->tipoEntidad->entidad->nombre_razon_social;
        $typeName = $associateTypeAssociate->tipoAsociado->nombre;
        $typeCode = $associateTypeAssociate->tipoAsociado->code;
        

        // 🔥 Obtener TODAS las cuentas contables asociadas a la empresa
        // $baseAccounts = $company->accountingAccounts()->get();
        $baseAccounts = $company->accountingAccounts()->where('is_base', true)->get();


        if ($baseAccounts->isEmpty()) {
            return redirect()->back()->with('error', 'Esta empresa no tiene cuentas contables base asignadas.');
        }

        if ($baseAccounts->isNotEmpty()) {
            foreach ($baseAccounts as $baseAccount) {

                $existingAccount = AccountingAccount::where('own_company_id', $companyId)
                    ->where('parent_id', $baseAccount->id)
                    ->where('name', "{$typeCode} - {$associateName} - {$typeName}")
                    ->first();

                if ($existingAccount) {
                    // 🚨 Si la cuenta ya existe, lanzar un mensaje de error
                    return redirect()->back()->with('error', "Esta empresa ya tiene una cuenta asociada a {$associateName} {$typeName}.");
                }

                if (!$existingAccount) {
                    $newAccount = AccountingAccount::create([
                        // 'code' => $this->generateAccountCode($companyId, $baseAccount->code),
                        'code' => $this->generateAccountCode($baseAccount),
                        'name' => "{$typeCode} - {$associateName} - {$typeName}",
                        'description' => "Subcuenta generada automáticamente para {$associateName}",
                        'sports_trading' => $baseAccount->sports_trading,
                        'accounting_type' => $baseAccount->accounting_type,
                        'currencies_id' => $baseAccount->currencies_id,
                        // 'level' => $baseAccount->level,
                        'level' => 'Sub-Cuenta',
                        'category_id' => $baseAccount->category_id,
                        'parent_id' => $baseAccount->id,
                        'own_company_id' => $companyId,
                    ]);

                    // ✅ 3️⃣ ASOCIAR CUENTA CONTABLE A TRAVÉS DE company_associate_accounting
                    CompanyAssociateAccounting::create([
                        'own_company_id' => $companyId,
                        'associate_type_associate_id' => $associateTypeAssociateId,
                        'accounting_account_id' => $newAccount->id,
                    ]);
                }
            }
        }

        // 🔥 Buscar cuenta base válida con sports_trading = true
        $parentAccount = CompanyAssociateAccounting::where('associate_type_associate_id', $associateTypeAssociateId)
            ->where('own_company_id', $companyId)
            ->whereHas('accountingAccount', function ($query) {
                $query->where('sports_trading', true);
            })
            ->with('accountingAccount')
            ->first();

        if ($parentAccount) {
            // 🔥 Buscar combinaciones directamente desde casa_de_apuesta_moneda
            // $bettingHouseCurrencies = BettingHouseCurrency::with('casaDeApuesta', 'moneda')->get();
            $bettingHouseCurrencies = BettingHouseCurrency::with('casaDeApuesta', 'moneda')
                ->where('estado', 'activo')
                ->get();

            foreach ($bettingHouseCurrencies as $bettingHouseCurrency) {
                $bettingHouseName = $bettingHouseCurrency->casaDeApuesta->nombre;
                $currencyName = $bettingHouseCurrency->moneda->cod;
                $parentAccountId = $parentAccount->accountingAccount->id;
                $associateNameCodSistema = $associateTypeAssociate->code_sistema;


                // 🚨 Verificar si ya existe la cuenta contable para esta combinación
                $existingBettingAccount = AccountingAccount::where('own_company_id', $companyId)->where('parent_id', $parentAccountId)->where('name', "{$bettingHouseName} - {$currencyName} - {$associateName}")->first();

                if (!$existingBettingAccount) {
                    // ✅ Crear la subcuenta automáticamente
                    $bettingAccount = AccountingAccount::create([
                        'code' => $this->generateAccountCode($parentAccount->accountingAccount),
                        'name' => "{$associateNameCodSistema} - {$bettingHouseName} - {$currencyName}",
                        'description' => "Subcuenta para {$bettingHouseName} en {$currencyName}",
                        'sports_trading' => true,
                        'accounting_type' => $parentAccount->accountingAccount->accounting_type,
                        'currency_id' => $bettingHouseCurrency->moneda_id,
                        'level' => 'Registro',
                        'category_id' => $parentAccount->accountingAccount->category_id,
                        'parent_id' => $parentAccountId,
                        'own_company_id' => $companyId,
                    ]);

                    // ✅ Crear automáticamente en casa_de_apuesta_asociado_accounting
                    CasaDeApuestaAsociadoAccounting::create([
                        'casa_de_apuesta_id' => $bettingHouseCurrency->casa_de_apuesta_id,
                        'asociado_tipo_asociado_id' => $associateTypeAssociateId,
                        'accounting_account_id' => $bettingAccount->id,
                    ]);
                }
            }
        }
        return redirect()->back()->with('success', 'Relación Empresa-Asociado-Cuenta creada con éxito');
    }

    // ✅ Generador de código único para las cuentas
    private function generateAccountCode($baseAccount)
    {
        // 🔍 Buscar la última cuenta hija usando la relación children
        $lastAccount = $baseAccount->children()
            ->orderBy('code', 'desc')
            ->first();

        // dd($lastAccount);

        if ($lastAccount) {
            // Extraer el número incremental del código
            $lastNumber = (int) substr($lastAccount->code, strlen($baseAccount->code) + 1);
            // $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            $nextNumber = $lastNumber + 1;
            return "{$baseAccount->code}.{$nextNumber}";
        }

        return "{$baseAccount->code}.1";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $relation = CompanyAssociateAccounting::with(['company', 'associateTypeAssociate', 'accountingAccount'])->findOrFail($id);
        return view('company_associate_accounting.show', compact('relation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $relation = CompanyAssociateAccounting::findOrFail($id);

        $companies = OwnCompany::all();
        $assocTypeAssoc = AssociateTypeAssociate::with(['associate', 'associateType'])->get();
        $accounts = AccountingAccount::all();

        return view('company_associate_accounting.edit', compact('relation', 'companies', 'assocTypeAssoc', 'accounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $relation = CompanyAssociateAccounting::findOrFail($id);

        $request->validate([
            'own_company_id' => 'required|exists:own_companies,id',
            'associate_type_associate_id' => 'required|exists:associate_type_associates,id',
            'accounting_account_id' => 'required|exists:accounting_accounts,id',
        ]);

        $relation->update($request->all());
        return redirect()->route('company-associate-accounting.index')
            ->with('success', 'Relación Empresa-Asociado-Cuenta actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $relation = CompanyAssociateAccounting::findOrFail($id);
        $relation->delete();

        return redirect()->route('company-associate-accounting.index')
            ->with('success', 'Relación Empresa-Asociado-Cuenta eliminada con éxito');
    }
}
