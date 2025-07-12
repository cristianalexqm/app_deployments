<?php

namespace App\Http\Controllers\Entidades;

use App\Http\Controllers\Controller;
use App\Models\AFPCommissionType;
use App\Models\AFPType;
use App\Models\Associate;
use App\Models\AssociateType;
use App\Models\BankType;
use App\Models\Currency;
use App\Models\DocumentType;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\OwnCompany;
use App\Models\Type;
use App\Models\WorkerType;
use Illuminate\Http\Request;

class EntityTypeController extends Controller
{
    // 📌 Muestra los tipos asignados y la pantalla para gestionarlos
    public function index($entityId)
    {
        $entity = Entity::with('tiposEntidades')->findOrFail($entityId);
        $tipos = Type::all(); // Todos los tipos disponibles
        $asignados = $entity->tiposEntidades->pluck('tipo_id')->toArray(); // Tipos ya asignados

        // ✅ Variables necesarias para los formularios en la vista
        $workerTypes = WorkerType::all();
        $currencies = Currency::all();
        $bankTypes = BankType::all();
        $afpTypes = AFPType::all();
        $afpCommissionTypes = AFPCommissionType::all();
        $associateTypes = AssociateType::all();
        $documentTypes = DocumentType::all();

        // Buscar si la entidad tiene un tipo de entidad de empleado (tipo_id = 1)
        $empleado = $entity->tiposEntidades->where('tipo_id', 1)->first()?->empleado;

        // ✅ Obtener entidades que tienen el tipo "Accionista" e incluir su tipo de documento y documento
        $accionistas = EntityType::where('tipo_id', 6) // Solo accionistas
            ->with([
                'entidad:id,nombre_razon_social,tipo_documento_id,documento',
                'entidad.tipoDocumento:id,code,nombre' // 🔥 Cargar correctamente la relación tipoDocumento
            ])
            ->get();

        /* dd($accionistas->toArray()); */

        // ✅ Verificar si la entidad ya tiene datos en Cliente o Proveedor
        $proveedor = $entity->tiposEntidades->where('tipo_id', 2)->first()?->proveedor;
        $cliente = $entity->tiposEntidades->where('tipo_id', 3)->first()?->cliente;

        // ✅ Si tiene datos en Proveedor pero no en Cliente, usamos los de Proveedor en Cliente
        if (!$cliente && $proveedor) {
            $cliente = (object) [
                'tipo_banco_id' => $proveedor->tipo_banco_id,
                'cuenta_bancaria' => $proveedor->cuenta_bancaria,
                'aval' => $proveedor->aval,
            ];
        }

        // ✅ Si tiene datos en Cliente pero no en Proveedor, usamos los de Cliente en Proveedor
        if (!$proveedor && $cliente) {
            $proveedor = (object) [
                'tipo_banco_id' => $cliente->tipo_banco_id,
                'cuenta_bancaria' => $cliente->cuenta_bancaria,
                'aval' => $cliente->aval,
            ];
        }

        // Buscar el tipo de entidad 4
        $tipoEntidad = $entity->tiposEntidades->where('tipo_id', 4)->first();

        $asociado = null;
        $tiposAsociado = [];
        $correosAsociado = [];
        $correosUsados = 0;

        // Si existe el tipo de entidad, buscar el asociado
        if ($tipoEntidad) {
            $asociado = Associate::where('dato_extra_tipo_entidad_id', $tipoEntidad->id)->first();
        }

        // ✅ Si existe el asociado, obtener sus tipos y correos dinámicamente
        if ($asociado) {
            // Tipos asociados
            $tiposAsociado = $asociado->tiposAsociados->pluck('tipo_asociado_id')->toArray();

            // ✅ Obtener correos directamente desde la relación
            $correosAsociado = $asociado->correos->pluck('correo')->toArray();

            // ✅ Contar correos directamente desde la relación
            $correosUsados = $asociado->correos->count();
        }

        // Buscar el tipo de entidad 5 (Empresa Propia)
        $tipoEntidadEmpresa = $entity->tiposEntidades->where('tipo_id', 5)->first();

        $empresaPropia = null;
        $accionistasEmpresa = [];

        if ($tipoEntidadEmpresa) {
            // Obtener la empresa propia si existe
            $empresaPropia = OwnCompany::where('dato_extra_tipo_entidad_id', $tipoEntidadEmpresa->id)->first();

            if ($empresaPropia) {
                // Obtener accionistas de la empresa propia
                $accionistasEmpresa = $empresaPropia
                    ? $empresaPropia->accionistas()->with(['tipoEntidad.entidad.tipoDocumento'])->get()
                    : [];
            }
        }
        //dd($accionistasEmpresa->toArray());

        /* dd($accionistas); */

        // Depuración final
        //dd($entity, $tipoEntidad, $asociado, $tiposAsociado, $correosAsociado);

        return view('entities_section.entity_types.index', compact(
            'entity',
            'tipos',
            'asignados',
            'workerTypes',
            'currencies',
            'bankTypes',
            'afpTypes',
            'afpCommissionTypes',
            'associateTypes',
            'documentTypes',
            'accionistas',
            'empleado',
            'cliente',
            'proveedor',
            'asociado',
            'tiposAsociado',
            'correosAsociado',
            'correosUsados',
            'empresaPropia',
            'accionistasEmpresa',
        ));
    }

    // 📌 Asigna o elimina tipos en la entidad
    public function store(Request $request, $entityId)
    {
        $entity = Entity::findOrFail($entityId);

        // Validar la selección de tipos
        $request->validate([
            'tipo_ids'   => 'array',
            'tipo_ids.*' => 'exists:tipos,id'
        ]);

        // Obtener los IDs seleccionados en el formulario
        $tiposSeleccionados = $request->tipo_ids ?? [];
        $tiposActuales = $entity->tiposEntidades->pluck('tipo_id')->toArray();

        // Determinar tipos nuevos y tipos a eliminar
        $tiposNuevos = EntityType::where('entidad_id', $entity->id)
            ->whereIn('tipo_id', $tiposSeleccionados)
            ->where('estado', 'inactivo')
            ->pluck('tipo_id')
            ->toArray();

        $tiposNuevos = array_merge($tiposNuevos, array_diff($tiposSeleccionados, $tiposActuales));
        $tiposEliminar = array_diff($tiposActuales, $tiposSeleccionados);

        // **Eliminar tipos deseleccionados**
        foreach ($tiposEliminar as $tipoId) {
            $tipoEntidad = EntityType::where('entidad_id', $entity->id)
                ->where('tipo_id', $tipoId)
                ->first();

            if ($tipoEntidad) {
                if ($this->tieneDatosRelacionados($tipoEntidad)) {
                    // Si tiene datos, solo lo inactivamos en lugar de eliminarlo
                    $tipoEntidad->update([
                        'estado' => 'inactivo',
                        'fecha_baja' => now()
                    ]);
                } else {
                    $tipoEntidad->delete();
                }
            }
        }

        // **Reactivar o asignar los nuevos tipos seleccionados**
        foreach ($tiposNuevos as $tipoId) {
            $tipoEntidad = EntityType::where('entidad_id', $entity->id)
                ->where('tipo_id', $tipoId)
                ->first();

            if ($tipoEntidad) {
                // Si ya existía pero estaba inactivo, lo reactivamos
                $tipoEntidad->update([
                    'estado' => 'activo',
                    'fecha_alta' => now(),
                    'fecha_baja' => null
                ]);
            } else {
                // Si no existía, lo creamos
                EntityType::create([
                    'entidad_id' => $entity->id,
                    'tipo_id'    => $tipoId,
                    'code'       => $this->generarCodigoParaTipo($tipoId),
                    'estado'     => 'activo',
                    'fecha_alta' => now()
                ]);
            }
        }
        return redirect()->back()->with('success', 'Tipos asignados correctamente.');
    }

    // 📌 Verifica si un tipo tiene datos relacionados en otras tablas
    private function tieneDatosRelacionados($tipoEntidad)
    {
        return $tipoEntidad->empleado()->exists()
            || $tipoEntidad->cliente()->exists()
            || $tipoEntidad->proveedor()->exists()
            || $tipoEntidad->empresaPropia()->exists()
            || $tipoEntidad->asociadoTrading()->exists()
            || $tipoEntidad->accionistaEmpresaPropia()->exists(); // 🔹 Agregado para Accionistas
    }

    // 📌 Genera un código único para cada tipo asignado a una entidad
    private function generarCodigoParaTipo($tipo_id)
    {
        $tipo = Type::findOrFail($tipo_id);

        $nombreDividido = explode(' ', trim($tipo->nombre));
        $prefijo = (count($nombreDividido) > 1) ?
            strtoupper(substr($nombreDividido[0], 0, 1) . substr($nombreDividido[1], 0, 1)) :
            strtoupper(substr($tipo->nombre, 0, 2));

        $ultimo = EntityType::where('code', 'like', $prefijo . '%')
            ->orderBy('code', 'desc')
            ->first();

        $num = $ultimo ? ((int)substr($ultimo->code, -4) + 1) : 1;
        return $prefijo . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
}
