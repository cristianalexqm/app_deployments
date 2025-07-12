<?php

namespace App\Http\Controllers\Entidades;

use App\Http\Controllers\Controller;
use App\Models\AFPCommissionType;
use App\Models\AFPType;
use App\Models\BankType;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\WorkerType;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index(Request $request)
    {
        // ✅ Capturar valor de per_page desde el request (por defecto 10)
        $perPage = $request->input('per_page', 10);

        // 1️⃣ Obtener entidades que tienen el tipo 'Empleado' (tipo_id = 1)
        $entities = Entity::whereHas('tiposEntidades', function ($query) {
            $query->where('tipo_id', 1); // 🔹 Solo empleados
        })
            ->with([
                'tipoDocumento',
                'tiposEntidades' => function ($query) {
                    $query->where('tipo_id', 1); // 🔹 Filtrar solo los tipos de empleado
                },
                'tiposEntidades.tipo',
                'tiposEntidades.empleado',
                'persona',
                'empresa'
            ])
            ->paginate($perPage); // 📌 Agregamos paginación

        // 2️⃣ Obtener el empleado seleccionado (Por defecto, el primero en la lista)
        $selectedEntity = $entities->first();

        // 3️⃣ Si el usuario seleccionó una entidad específica, la obtenemos
        if ($request->has('selected')) {
            $selectedEntity = Entity::whereHas('tiposEntidades', function ($query) {
                $query->where('tipo_id', 1); // 🔹 Solo empleados
            })
                ->with([
                    'tipoDocumento',
                    'tiposEntidades' => function ($query) {
                        $query->where('tipo_id', 1); // 🔹 Solo empleados
                    },
                    'tiposEntidades.tipo',
                    'tiposEntidades.empleado',
                    'persona',
                    'empresa'
                ])
                ->find($request->selected);
        }

        // 4️⃣ Devolver la vista con las entidades filtradas
        return view('entities_section.entity_types.employee_types.index', compact('entities', 'selectedEntity'));
    }

    public function store(Request $request, $entityId)
    {
        $request->validate([
            'tipo_trabajador_id' => 'required|exists:tipo_trabajador,id',
            'cargo' => 'required|string|max:255',
            'moneda_id' => 'required|exists:monedas,id',
            'reembolso_basico' => 'nullable|numeric|min:0',
            'cups_essalud' => 'nullable|string|max:50',
            'hijos_asignados_familia' => 'nullable|integer|min:0',
            'tipo_banco_sueldo' => 'nullable|exists:tipos_bancos,id',
            'cuenta_banco' => 'nullable|string|max:50',
            'cci_banco' => 'nullable|string|max:50',
            'eleccion_fondo' => 'required|string|in:AFP,ONP',
            'tipo_afp_id' => 'nullable|exists:tipo_afp,id',
            'tipo_comision_afp_id' => 'nullable|exists:tipo_comision_afp,id',
        ]);

        $tipoEntidad = EntityType::where('entidad_id', $entityId)->where('tipo_id', 1)->firstOrFail();

        try {
            Employee::create([
                'dato_extra_tipo_entidad_id' => $tipoEntidad->id,
                'tipo_trabajador_id' => $request->tipo_trabajador_id,
                'cargo' => $request->cargo,
                'moneda_id' => $request->moneda_id,
                'reembolso_basico' => $request->reembolso_basico,
                'cups_essalud' => $request->cups_essalud,
                'hijos_asignados_familia' => $request->hijos_asignados_familia,
                'tipo_banco_sueldo' => $request->tipo_banco_sueldo,
                'cuenta_banco' => $request->cuenta_banco,
                'cci_banco' => $request->cci_banco,
                'eleccion_fondo' => $request->eleccion_fondo,
                'tipo_afp_id' => $request->tipo_afp_id,
                'tipo_comision_afp_id' => $request->tipo_comision_afp_id,
            ]);

            return redirect()->back()->with('success', 'Empleado: Los datos adicionales para la entidad han sido registrados correctamente.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error: La entidad seleccionada ya tiene datos adicionales asignados. Solo se permite un registro por entidad.');
        }
    }

    public function edit($id)
    {
        // ✅ Buscar el empleado por ID directamente en la tabla `employees`
        $empleado = Employee::findOrFail($id);

        // ✅ Obtener datos para selects
        $workerTypes = WorkerType::all();
        $currencies = Currency::all();
        $bankTypes = BankType::all();
        $afpTypes = AfpType::all();
        $afpCommissionTypes = AfpCommissionType::all();

        return view('entities_section.entity_types.employee_types.edit', compact(
            'empleado',
            'workerTypes',
            'currencies',
            'bankTypes',
            'afpTypes',
            'afpCommissionTypes'
        ));
    }

    public function update(Request $request, $id)
    {
        // ✅ Validar los datos de entrada
        $request->validate([
            'tipo_trabajador_id' => 'required|exists:tipo_trabajador,id',
            'cargo' => 'required|string|max:255',
            'moneda_id' => 'required|exists:monedas,id',
            'reembolso_basico' => 'nullable|numeric|min:0',
            'cups_essalud' => 'nullable|string|max:50',
            'hijos_asignados_familia' => 'nullable|integer|min:0',
            'tipo_banco_sueldo' => 'nullable|exists:tipos_bancos,id',
            'cuenta_banco' => 'nullable|string|max:50',
            'cci_banco' => 'nullable|string|max:50',
            'eleccion_fondo' => 'required|string|in:AFP,ONP',
            'tipo_afp_id' => 'nullable|exists:tipo_afp,id',
            'tipo_comision_afp_id' => 'nullable|exists:tipo_comision_afp,id',
        ]);

        // ✅ Buscar al empleado por el ID de entidad
        $empleado = Employee::where('dato_extra_tipo_entidad_id', $id)->firstOrFail();

        // ✅ Preparar los datos para la actualización
        $data = $request->all();

        // 🔹 Si el usuario selecciona ONP, limpiar los campos de AFP y comisión AFP
        if ($request->eleccion_fondo === 'ONP') {
            $data['tipo_afp_id'] = null;
            $data['tipo_comision_afp_id'] = null;
        }

        // ✅ Actualizar los datos del empleado en la base de datos
        $empleado->update($data);

        // ✅ Redireccionar con mensaje de éxito
        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
    }
}
