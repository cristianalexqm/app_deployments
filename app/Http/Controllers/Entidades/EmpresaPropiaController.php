<?php

namespace App\Http\Controllers\Entidades;

use App\Http\Controllers\Controller;
use App\Models\AccountingAccount;
use App\Models\Category;
use App\Models\DatosPersonalesBancarios;
use App\Models\DocumentType;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\OwnCompany;
use App\Models\ShareholderOwnCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmpresaPropiaController extends Controller
{
    public function index(Request $request)
    {
        // ✅ Capturar valor de per_page desde el request (por defecto 10)
        $perPage = $request->input('per_page', 10);

        // 1️⃣ Obtener entidades que tienen el tipo "Empresa Propia" (tipo_id = 5)
        $entities = Entity::whereHas('tiposEntidades', function ($query) {
            $query->where('tipo_id', 5); // 🔹 Solo empresas propias
        })
            ->with([
                'tipoDocumento',
                'tiposEntidades' => function ($query) {
                    $query->where('tipo_id', 5); // 🔹 Filtrar solo los tipos de empresa propia
                },
                'tiposEntidades.tipo',
                'tiposEntidades.empresaPropia', // 🔹 Relación con empresa propia
                'persona',
                'empresa'
            ])
            ->paginate($perPage); // 📌 Paginación

        // 2️⃣ Obtener la primera empresa de la lista como selección inicial (si existe)
        $selectedEmpresa = null;
        if ($entities->isNotEmpty()) {
            $selectedEmpresa = $entities->first()->tiposEntidades->firstWhere('tipo_id', 5)?->empresaPropia;
        }

        // 3️⃣ Si el usuario seleccionó una empresa específica, la obtenemos
        if ($request->has('selected')) {
            $selectedEmpresa = OwnCompany::with([
                'tipoEntidad.entidad.tipoDocumento',
                'tipoDocumento',
                'accionistas.tipoEntidad.entidad'
            ])->find($request->selected);
        }

        // 4️⃣ Devolver la vista con las empresas propias filtradas
        return view('entities_section.entity_types.own_company.index', compact('entities', 'selectedEmpresa'));
    }

    public function store(Request $request, $entityId)
    {
        // 🔍 **Debugging inicial (para ver datos enviados)**
        Log::info("📥 Datos recibidos:", $request->all());

        try {
            DB::beginTransaction(); // 🚀 **Iniciar transacción para evitar registros incompletos**

            // ✅ Verificar si la empresa ya existe
            $empresa = OwnCompany::whereHas('tipoEntidad', function ($query) use ($entityId) {
                $query->where('entidad_id', $entityId);
            })->first();

            if (!$empresa) {
                // ✅ Si la empresa no existe, validar todos los datos y crearla
                $request->validate([
                    'representante_legal' => 'required|string|max:255',
                    'tipo_documento_id' => 'required|exists:tipo_documentos,id',
                    'documento_gerente' => 'required|string|max:50',
                    'partida_registral' => 'nullable|string|max:100',
                    'oficina_registral' => 'nullable|string|max:255',
                    'fecha_constitucion' => 'required|date',
                    'estado_empresa' => 'required|string|in:activa,inactiva,suspendida',
                    'fecha_cierre' => 'nullable|date',
                    'nro_acciones_total' => 'required|integer|min:1',
                    'correo_empresa' => 'required|email|max:255',
                    'password' => 'required|string|min:6',
                    'tipo_control' => 'required|string|in:tributario,financiero',
                ]);

                // ✅ Buscar el tipo de entidad de la empresa propia
                $tipoEntidad = EntityType::where('entidad_id', $entityId)
                    ->where('tipo_id', 5)
                    ->firstOrFail();

                // ✅ Crear la empresa propia
                $empresa = OwnCompany::create([
                    'dato_extra_tipo_entidad_id' => $tipoEntidad->id,
                    'representante_legal' => $request->representante_legal,
                    'tipo_documento_id' => $request->tipo_documento_id,
                    'documento_gerente' => $request->documento_gerente,
                    'partida_registral' => $request->partida_registral,
                    'oficina_registral' => $request->oficina_registral,
                    'fecha_constitucion' => $request->fecha_constitucion,
                    'estado_empresa' => $request->estado_empresa,
                    'fecha_cierre' => $request->fecha_cierre,
                    'nro_acciones_total' => $request->nro_acciones_total,
                    'correo_empresa' => $request->correo_empresa,
                    'password' => $request->password,
                    'tipo_control' => $request->tipo_control,
                ]);

                Log::info("✅ Empresa registrada con ID: {$empresa->id}");
            } else {
                // ✅ Si la empresa ya existe, evitar validar datos de empresa
                Log::info("⚠ Empresa ya existe, solo se agregarán accionistas.");
            }

            // ✅ Registrar nuevos accionistas si existen
            if ($request->has('accionistas') && is_array($request->accionistas) && count($request->accionistas) > 0) {
                $totalAccionesAsignadas = 0;
                $totalPorcentajeAsignado = 0;
                $accionistasInsertados = 0; // Contador de accionistas insertados

                // 🔹 Filtrar valores inválidos antes de procesarlos
                foreach ($request->accionistas as $index => $accionistaId) {

                    if (!$accionistaId) continue; // Si el accionista es null o vacío, lo ignoramos

                    // 🔹 Verifica que los datos del accionista no sean nulos o vacíos
                    if (
                        !isset($request->nro_acciones[$index]) || !isset($request->porcentaje_acciones[$index]) ||
                        empty($request->nro_acciones[$index]) || empty($request->porcentaje_acciones[$index])
                    ) {
                        Log::warning("⛔ Accionista $accionistaId tiene valores inválidos, omitiendo...");
                        continue;
                    }
                    // Convierte los valores a números
                    $nroAcciones = (int) $request->nro_acciones[$index];
                    $porcentajeAcciones = (float) $request->porcentaje_acciones[$index];
                    $fechaDesde = !empty($request->fecha_desde[$index]) ? $request->fecha_desde[$index] : null;
                    $fechaHasta = !empty($request->fecha_hasta[$index]) ? $request->fecha_hasta[$index] : null;

                    // ✅ Verificar que los valores sean positivos
                    if ($nroAcciones <= 0 || $porcentajeAcciones <= 0) {
                        Log::warning("⚠️ Accionista $accionistaId tiene valores inválidos (Acciones: $nroAcciones, Porcentaje: $porcentajeAcciones), omitiendo...");
                        continue;
                    }

                    // ✅ Verificar que la cantidad de acciones no supere el total
                    $totalAccionesAsignadas += $nroAcciones;
                    $totalPorcentajeAsignado += $porcentajeAcciones;

                    if ($totalAccionesAsignadas > $empresa->nro_acciones_total) {
                        Log::error("❌ Acciones asignadas ($totalAccionesAsignadas) superan el límite total permitido ({$empresa->nro_acciones_total}).");
                        return redirect()->back()->withErrors([
                            'nro_acciones' => 'La cantidad total de acciones asignadas supera el límite permitido.'
                        ]);
                    }

                    if ($totalPorcentajeAsignado > 100) {
                        Log::error("❌ Porcentaje de acciones ($totalPorcentajeAsignado%) excede el 100%.");
                        return redirect()->back()->withErrors([
                            'porcentaje_acciones' => 'La suma del porcentaje de acciones no puede superar el 100%.'
                        ]);
                    }
                    // ✅ Insertar cada accionista en la tabla `accionista_empresa_propia`
                    try {
                        ShareholderOwnCompany::create([
                            'empresa_propia_id' => $empresa->id,
                            'tipo_entidad_id' => $accionistaId,
                            'nro_acciones' => $nroAcciones,
                            'porcentaje_acciones' => $porcentajeAcciones,
                            'fecha_desde' => $fechaDesde,
                            'fecha_hasta' => $fechaHasta,
                        ]);
                        Log::info("✔ Accionista $accionistaId agregado a empresa {$empresa->id}");
                        $accionistasInsertados++; // Contador de accionistas insertados
                    } catch (\Exception $e) {
                        Log::error("❌ Error al insertar accionista ID: $accionistaId", ['error' => $e->getMessage()]);
                        return redirect()->back()->withErrors([
                            'error' => 'Ocurrió un error al registrar un accionista: ' . $e->getMessage()
                        ]);
                    }
                }

                // ✅ Mostrar mensaje de éxito solo si se insertó al menos un accionista
                if ($accionistasInsertados > 0) {
                    DB::commit(); // ✅ **Confirmar la transacción**
                    return redirect()->back()->with('success', "✅ $accionistasInsertados accionista(s) agregado(s) correctamente.");
                } else {
                    DB::rollBack(); // ❌ **Revertir transacción si no se insertó ninguno**
                    return redirect()->back()->withErrors([
                        'error' => 'No se agregó ningún accionista debido a valores inválidos.'
                    ]);
                }
            }

            DatosPersonalesBancarios::create(['tipo_entidad_id' => $tipoEntidad->id]);

            // ✅ Confirmar la transacción en caso de éxito
            DB::commit();
            // return redirect()->back()->with('success', 'Empresa propia agregada correctamente.');
            return redirect()->route('empresa_propia.showAssignCompanyForm', $empresa->id)
                ->with('success', 'Empresa guardada correctamente. Ahora puedes asignar cuentas contables.');
        } catch (\Exception $e) {
            DB::rollBack(); // ❌ **Revertir cambios en caso de error**
            Log::error("❌ Error general al guardar empresa", ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Ocurrió un error al guardar los datos. ' . $e->getMessage());
        }
    }

    public function showAssignCompanyForm($id)
    {
        // $company = OwnCompany::findOrFail($id);
        // $company = OwnCompany::with('accountingAccounts')->where('is_base', true)->findOrFail($id);
        $company = OwnCompany::with([
            'accountingAccounts' => function ($query) {
                $query->where('is_base', true);
            },
            'tipoEntidad.entidad'
        ])->findOrFail($id);
        // dd($company);

        $categories = Category::all();
        $categoryId = request('category_id');
        $accounts = AccountingAccount::parents($categoryId)->get();

        if (request()->ajax()) {
            return view('entities_section.entity_types.own_company.partials.accounts_list', compact('accounts'))->render();
        }

        return view('entities_section.entity_types.own_company.assignCompany', compact('company', 'accounts', 'categories', 'categoryId'))
            ->with('success', 'Cuentas contables obtenidas con éxito.');
    }

    public function assignCompany(Request $request, $id)
    {
        try {
            // 1️⃣ Verifica si la empresa existe
            $company = OwnCompany::findOrFail($id);
            // dd($company);
            // 2️⃣ Validación del formulario
            $validatedData = $request->validate([
                'accounting_account_id' => 'required|array|min:1', // Asegura que al menos una cuenta sea seleccionada
                'accounting_account_id.*' => 'exists:accounting_accounts,id', // Verifica que las cuentas existen
                'sports_trading' => 'array', // Asegura que sports_trading es un array
                'sports_trading.*' => 'nullable|in:0,1', // Asegura que cada valor es 0 o 1 o null
            ]);

            // 3️⃣ Obtener las cuentas contables seleccionadas
            $selectedAccounts = AccountingAccount::whereIn('id', $validatedData['accounting_account_id'])->get();

            // 🚨 4️⃣ Verificar si alguna cuenta base YA está asignada a otra empresa
            $alreadyAssigned = $selectedAccounts->filter(function ($account) use ($company) {
                return $account->own_company_id !== null && $account->own_company_id !== $company->id;
            });

            if ($alreadyAssigned->isNotEmpty()) {
                // 🚫 Si alguna cuenta base ya está asignada a otra empresa, lanzamos un error
                return redirect()->back()->with('error', 'Algunas cuentas base ya están asignadas a otra empresa y no pueden reasignarse.');
            }

            // 5️⃣ Filtrar cuentas que ya están asignadas a la misma empresa
            $accountsToUpdate = $selectedAccounts->filter(function ($account) use ($company) {
                return $account->own_company_id !== $company->id;
            });

            // 6️⃣ Si no hay cambios, redirigir sin actualizar
            if ($accountsToUpdate->isEmpty()) {
                return redirect()->back()->with('info', 'Todas las cuentas ya están asignadas a esta empresa.');
            }

            // 7️⃣ Asignar las cuentas a la empresa y actualizar sports_trading
            foreach ($accountsToUpdate as $account) {
                $account->update([
                    'own_company_id' => $company->id,
                    'sports_trading' => $validatedData['sports_trading'][$account->id] ?? null, // Si no se envía, dejar null
                    'is_base' => true // ✅ Marcar como cuenta base
                ]);
            }

            return redirect()->back()->with('success', 'Cuentas contables asignadas y actualizadas correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }

    public function unassignAccount($companyId, $accountId)
    {
        $account = AccountingAccount::where('id', $accountId)
            ->where('own_company_id', $companyId)
            ->firstOrFail();

        $account->update(['own_company_id' => null]);

        return redirect()->back()->with('success', 'Cuenta contable desasignada correctamente.');
    }


    public function edit($id)
    {
        // Buscar la empresa con sus relaciones necesarias
        $empresa = OwnCompany::with([
            'tipoEntidad.entidad.tipoDocumento',
            'tipoDocumento',
            'accionistas.tipoEntidad.entidad' // Para mostrar los accionistas en la vista
        ])->findOrFail($id);

        $tiposDocumentos = DocumentType::all();

        // Devolver la vista con los datos cargados
        return view('entities_section.entity_types.own_company.edit', compact('empresa', 'tiposDocumentos'));
    }

    public function update(Request $request, $id)
    {
        // Buscar la empresa propia
        $empresa = OwnCompany::findOrFail($id);

        // Validar los datos recibidos
        $request->validate([
            'representante_legal' => 'required|string|max:255',
            'tipo_documento_id' => 'required|exists:tipo_documentos,id',
            'documento_gerente' => 'required|string|max:50',
            'partida_registral' => 'nullable|string|max:100',
            'oficina_registral' => 'nullable|string|max:255',
            'fecha_constitucion' => 'required|date',
            'estado_empresa' => 'required|string|in:activa,inactiva,suspendida',
            'fecha_cierre' => 'nullable|date',
            'nro_acciones_total' => 'required|integer|min:1',
            'correo_empresa' => 'required|email|max:255',
            'password' => 'nullable|string|min:6',
            'tipo_control' => 'required|string|in:tributario,financiero',
        ]);

        // Datos a actualizar
        $dataToUpdate = [
            'representante_legal' => $request->representante_legal,
            'tipo_documento_id' => $request->tipo_documento_id,
            'documento_gerente' => $request->documento_gerente,
            'partida_registral' => $request->partida_registral,
            'oficina_registral' => $request->oficina_registral,
            'fecha_constitucion' => $request->fecha_constitucion,
            'estado_empresa' => $request->estado_empresa,
            'fecha_cierre' => $request->fecha_cierre,
            'nro_acciones_total' => $request->nro_acciones_total,
            'correo_empresa' => $request->correo_empresa,
            'tipo_control' => $request->tipo_control,
        ];

        // Si se proporciona una nueva contraseña, actualizarla
        if ($request->filled('password')) {
            $dataToUpdate['password'] = $request->password;
        }

        // Actualizar empresa con los datos validados
        $empresa->update($dataToUpdate);

        return redirect()->route('empresa_propia.index')->with('success', 'Empresa actualizada correctamente.');
    }
}
