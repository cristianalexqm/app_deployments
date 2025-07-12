<?php

namespace App\Http\Controllers\Entidades;

use App\Http\Controllers\Controller;
use App\Models\AccountingAccount;
use App\Models\Associate;
use App\Models\AssociateCompany;
use App\Models\AssociateTypeAssociate;
use App\Models\BettingHouseCurrency;
use App\Models\CasaDeApuestaAsociadoAccounting;
use App\Models\CompanyAssociateAccounting;
use App\Models\OwnCompany;
use App\Models\StatusAssignmentAssociatedCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssociateCompanyController extends Controller
{
    /**
     * ✅ Mostrar todos los registros (GET)
     */
    public function index()
    {
        $relaciones = AssociateCompany::with(['associateTypeAssociate', 'ownCompany', 'status'])
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($relaciones, 200);
    }

    /**
     * ✅ Mostrar el formulario para crear un nuevo registro (GET)
     */
    // public function create($id)
    // {
    //     $asociados = Associate::with([
    //         'associateCompanies.ownCompany.tipoEntidad.entidad',
    //         'tiposAsociados.tipoAsociado'
    //     ])->findOrFail($id);

    //     $statuses = StatusAssignmentAssociatedCompany::all();
    //     $companies = OwnCompany::with('tipoEntidad.entidad')->get();

    //     return view('entities_section.types.forms.asignar_empresa_asociado_trading', compact('companies', 'asociados', 'statuses'));
    // }
    public function create($id)
    {
        $asociados = Associate::with([
            'tiposAsociados.tipoAsociado', // asegúrate que esta relación cargue `tipo_control`
            'tiposAsociados.empresas.ownCompany.tipoEntidad.entidad',
        ])->findOrFail($id);

        $companies = OwnCompany::with('tipoEntidad.entidad')->get();

        // Agrupamos los tipos de asociado por tipo_control del tipo
        $tiposTributarios = $asociados->tiposAsociados->filter(function ($tipo) {
            return $tipo->tipoAsociado?->tipo_control === 'tributario';
        });

        $tiposFinancieros = $asociados->tiposAsociados->filter(function ($tipo) {
            return $tipo->tipoAsociado?->tipo_control === 'financiero';
        });

        return view('entities_section.types.forms.asignar_empresa_asociado_trading', compact(
            'asociados',
            'companies',
            'tiposTributarios',
            'tiposFinancieros'
        ));
    }


    /**
     * ✅ Guardar un nuevo registro (POST)
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'associated_id' => 'required|exists:asociado,id',
            'own_company_id' => 'required|exists:empresa_propia,id',
            'estado' => 'required|boolean'
            // 'estado' => 'required|exists:status_assignment_associated_companies,id'
        ]);
        // dd($validatedData);

        $associateId = $request->input('associated_id');
        $companyId = $request->input('own_company_id');

        //Extraemos datos de la empresa y del Asociado
        $company = OwnCompany::findOrFail($companyId);
        $associate = Associate::with('tipoEntidad.entidad')->findOrFail($associateId);
        $associateName = $associate->tipoEntidad->entidad->nombre_razon_social;

        $baseAccounts = $company->accountingAccounts()->where('is_base', true)->get();

        if ($baseAccounts->isEmpty()) {
            return redirect()->back()->with('error', 'Esta empresa no tiene cuentas contables base asignadas.');
        }

        $existeRelacion = AssociateCompany::where('associated_id', $associateId)
            ->where('own_company_id', $companyId)
            ->exists();

        if ($existeRelacion) {
            return redirect()->back()->with('error', 'Esta empresa ya ha sido asignada previamente a este asociado.');
        }

        $relacion = AssociateCompany::create($validatedData);

        if ($baseAccounts->isNotEmpty()) {
            foreach ($baseAccounts as $baseAccount) {

                $hijaIds = AccountingAccount::where('own_company_id', $companyId)
                    ->where('parent_id', $baseAccount->id)
                    ->pluck('id');

                if (!$hijaIds) {
                    return redirect()->back()->with('error', "primer de verificacion paso error.");
                }

                $yaExisteParaAsociado = CompanyAssociateAccounting::whereIn('accounting_account_id', $hijaIds)
                    ->where('associate_company_id', $relacion->id)
                    ->exists();

                if ($yaExisteParaAsociado) {
                    return redirect()->back()->with('error', "Ya existe una subcuenta para este asociado en esta cuenta base.");
                }
                if (!$yaExisteParaAsociado) {
                    $newAccount = AccountingAccount::create([
                        'code' => $this->generateAccountCode($baseAccount),
                        'name' => "{$associateName}",
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
                        'accounting_account_id' => $newAccount->id,
                        'associate_company_id' => $relacion->id
                    ]);
                }
            }
        }


        // 🔥 Buscar cuenta base válida con sports_trading = true
        // $parentAccount = CompanyAssociateAccounting::where('associate_type_associate_company_id', $relacion->id)
        //     ->where('own_company_id', $companyId)
        //     ->whereHas('accountingAccount', function ($query) {
        //         $query->where('sports_trading', true);
        //     })
        //     ->with('accountingAccount')
        //     ->first();

        // if ($parentAccount) {
        //     // 🔥 Buscar combinaciones directamente desde casa_de_apuesta_moneda
        //     // $bettingHouseCurrencies = BettingHouseCurrency::with('casaDeApuesta', 'moneda')->get();
        //     $bettingHouseCurrencies = BettingHouseCurrency::with('casaDeApuesta', 'moneda')
        //         ->where('estado', 'activo')
        //         ->get();

        //     foreach ($bettingHouseCurrencies as $bettingHouseCurrency) {
        //         $bettingHouseName = $bettingHouseCurrency->casaDeApuesta->nombre;
        //         $currencyName = $bettingHouseCurrency->moneda->cod;
        //         $parentAccountId = $parentAccount->accountingAccount->id;


        //         // 🚨 Verificar si ya existe la cuenta contable para esta combinación
        //         $existingBettingAccount = AccountingAccount::where('own_company_id', $companyId)->where('parent_id', $parentAccountId)->where('name', "{$bettingHouseName} - {$currencyName} - {$associateName}")->first();

        //         if (!$existingBettingAccount) {
        //             // ✅ Crear la subcuenta automáticamente
        //             $bettingAccount = AccountingAccount::create([
        //                 'code' => $this->generateAccountCode($parentAccount->accountingAccount),
        //                 'name' => "{$associateName} - {$bettingHouseName} - {$currencyName}",
        //                 'description' => "Subcuenta para {$bettingHouseName} en {$currencyName}",
        //                 'sports_trading' => true,
        //                 'accounting_type' => $parentAccount->accountingAccount->accounting_type,
        //                 'currency_id' => $bettingHouseCurrency->moneda_id,
        //                 'level' => 'Registro',
        //                 'category_id' => $parentAccount->accountingAccount->category_id,
        //                 'parent_id' => $parentAccountId,
        //                 'own_company_id' => $companyId,
        //             ]);

        //             // ✅ Crear automáticamente en casa_de_apuesta_asociado_accounting
        //             CasaDeApuestaAsociadoAccounting::create([
        //                 'casa_de_apuesta_id' => $bettingHouseCurrency->casa_de_apuesta_id,
        //                 'asociado_tipo_asociado_id' => $associateTypeAssociateId,
        //                 'accounting_account_id' => $bettingAccount->id,
        //             ]);
        //         }
        //     }
        // }

        return redirect()->back()->with('success', 'Relación Empresa-Asociado-Cuenta creada con éxito');
    }


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
     * ✅ Mostrar un registro específico (GET)
     */
    public function show($id)
    {
        $relacion = AssociateCompany::with(['associateTypeAssociate', 'ownCompany', 'status'])
            ->findOrFail($id);

        return response()->json($relacion, 200);
    }

    /**
     * ✅ Mostrar el formulario para editar un registro específico (GET)
     */
    public function edit($id)
    {
        $relacion = AssociateCompany::findOrFail($id);
        $asociados = AssociateTypeAssociate::all();
        $empresas = OwnCompany::all();
        $estados = StatusAssignmentAssociatedCompany::all();

        return response()->json([
            'relacion' => $relacion,
            'asociados' => $asociados,
            'empresas' => $empresas,
            'estados' => $estados,
        ], 200);
    }

    /**
     * ✅ Actualizar un registro específico (PUT/PATCH)
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'estado' => 'required|boolean'
        ]);

        $relacion = AssociateCompany::findOrFail($id);
        $relacion->update($validatedData);
        return redirect()->back()->with('success-estado', 'Estado Empresa-Asociado actualizada con éxito');
    }

    /**
     * ✅ Eliminar un registro específico (DELETE)
     */
    public function destroy($id)
    {

        $relacion = AssociateCompany::findOrFail($id);
        $relacion->delete();
        return redirect()->back()->with('success-destroy', 'Relación Empresa-Asociado-Cuenta eliminada con éxito');
    }
}
