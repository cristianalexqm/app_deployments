<?php

namespace App\Http\Controllers\Entidades;

use App\Http\Controllers\Controller;
use App\Models\Associate;
use App\Models\AssociateType;
use App\Models\AssociateTypeAssociate;
use App\Models\DatosPersonalesBancarios;
use App\Models\Entity;
use App\Models\EntityType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsociadoTradingController extends Controller
{
    public function index(Request $request)
    {
        // ✅ Definir el valor de paginación desde el request o usar 10 como valor por defecto
        $perPage = $request->input('per_page', 10);

        // 1️⃣ Obtener entidades con tipo 'Asociado Trading' (tipo_id = 4)
        $entities = Entity::whereHas('tiposEntidades', function ($query) {
            $query->where('tipo_id', 4);
        })
            ->with([
                'tipoDocumento',
                'tiposEntidades' => function ($query) {
                    $query->where('tipo_id', 4);
                },
                'tiposEntidades.tipo',
                'tiposEntidades.asociadoTrading',
                'persona',
                'empresa'
            ])
            ->paginate($perPage); // 📌 Paginar resultados

        // 2️⃣ Obtener el Asociado seleccionado (Por defecto, el primero en la lista)
        $selectedEntity = $entities->first();

        // 3️⃣ Si el usuario seleccionó una entidad específica, la obtenemos
        if ($request->has('selected')) {
            $selectedEntity = Entity::whereHas('tiposEntidades', function ($query) {
                $query->where('tipo_id', 4);
            })
                ->with([
                    'tipoDocumento',
                    'tiposEntidades' => function ($query) {
                        $query->where('tipo_id', 4);
                    },
                    'tiposEntidades.tipo',
                    'tiposEntidades.asociadoTrading',
                    'tiposEntidades.asociadoTrading.correos', // 👈 🔥 Añadir la relación de correos
                    'persona',
                    'empresa'
                ])
                ->find($request->selected);
        }

        // 4️⃣ Devolver la vista con los datos filtrados
        return view('entities_section.entity_types.associated_trading.index', compact('entities', 'selectedEntity'));
    }

    public function store(Request $request, $entityId)
    {
        // Validación de datos
        $request->validate([
            'nick_apodo'          => 'nullable|string|max:50',
            'telefono'            => 'nullable|string|regex:/^\d{9,15}$/',
            'correo_recuperacion' => 'nullable|email|max:255',
            'tipos_asociados'     => 'sometimes|array',
            'tipos_asociados.*'   => 'exists:tipo_asociado,id',
            'correos'             => 'sometimes|array',
            'correos.*'           => 'nullable|email',
            'passwords'           => 'sometimes|array',
            'passwords.*'         => 'nullable|string|min:6',
        ]);

        // Buscar el EntityType con tipo_id = 4
        $tipoEntidad = EntityType::where('entidad_id', $entityId)
            ->where('tipo_id', 4)
            ->firstOrFail();

        // Ver si YA existe un 'asociado' vinculado
        $asociado = Associate::where('dato_extra_tipo_entidad_id', $tipoEntidad->id)->first();

        try {
            DB::beginTransaction();

            // 1. Crear/Actualizar datos básicos
            if (!$asociado) {
                $asociado = Associate::create([
                    'dato_extra_tipo_entidad_id' => $tipoEntidad->id,
                    'nick_apodo'          => $request->nick_apodo ?? '',
                    'telefono'            => $request->telefono ?? '',
                    'correo_recuperacion' => $request->correo_recuperacion ?? '',
                ]);
            }

            // 2. Añadir NUEVOS tipos asociados sin modificar los existentes
            if ($request->filled('tipos_asociados')) {
                $this->agregarNuevosTipos($asociado, $request->tipos_asociados);
            }

            // 3. Añadir NUEVOS correos sin tocar los existentes
            if ($request->filled('correos')) {
                $this->agregarNuevosCorreos($asociado, $request->correos, $request->passwords ?? []);
            }

            DatosPersonalesBancarios::create(['tipo_entidad_id' => $tipoEntidad->id]);

            DB::commit();

            // return redirect()->back()->with('success', 'Asociado: Datos guardados/actualizados correctamente.');
            // return redirect()->route('company-associate-accounting.create')->with('success', 'Asociado: Datos guardados/actualizados correctamente.');
            // dd($asociado->id);
            return redirect()->route('company-associate-accounting.create', $asociado->id)->with('success', 'Asociado: Datos guardados/actualizados correctamente.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Ocurrió un error al guardar los datos del Asociado. Intente nuevamente.');
        }
    }

    //Añadir nuevos tipos asociados sin borrar los viejos.
    private function agregarNuevosTipos(Associate $asociado, array $tiposAsociados)
    {
        $idsActuales = $asociado->tiposAsociados->pluck('tipo_asociado_id')->toArray();
        $nuevos = array_diff($tiposAsociados, $idsActuales);

        foreach ($nuevos as $tipoAsociadoId) {
            $codigo = $this->generarCodigoTipoAsociado($tipoAsociadoId);
            $codeSistema = $this->generarCodeSistema($tipoAsociadoId, $asociado->nick_apodo);

            $asociado->tiposAsociados()->create([
                'tipo_asociado_id' => $tipoAsociadoId,
                'code_tipo'        => $codigo,
                'code_sistema'     => $codeSistema,
                'estado'           => 'activo',
                'fecha_alta'       => now(),
            ]);
        }
    }

    // Añadir correos nuevos usando la relación (sin verificar duplicados)
    private function agregarNuevosCorreos(Associate $asociado, array $correos, array $passwords)
    {
        foreach ($correos as $index => $correo) {
            if (empty($correo)) continue;

            // Inserta directamente sin verificar si existe o no
            $asociado->correos()->create([
                'correo'   => $correo,
                'password' => $passwords[$index] ?? null
            ]);
        }
    }

    //Genera un code_tipo para 'asociado_tipo_asociado'.
    private function generarCodigoTipoAsociado($tipoId)
    {
        $tipo = AssociateType::findOrFail($tipoId);
        $nombreDividido = explode(' ', trim($tipo->nombre));
        $prefijo = (count($nombreDividido) > 1)
            ? strtoupper(substr($nombreDividido[0], 0, 1) . substr($nombreDividido[1], 0, 1))
            : strtoupper(substr($tipo->nombre, 0, 2));

        $ultimo = AssociateTypeAssociate::where('code_tipo', 'like', $prefijo . '%')
            ->orderBy('code_tipo', 'desc')
            ->first();

        $num = $ultimo ? ((int)substr($ultimo->code_tipo, -4)) + 1 : 1;

        return $prefijo . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

    //Genera 'code_sistema' para 'asociado_tipo_asociado'. - Formato: [Código generado] - [Nick/Apodo]
    private function generarCodeSistema($tipoId, $nickApodo)
    {
        $tipo = AssociateType::findOrFail($tipoId);
        $nombreDividido = explode(' ', trim($tipo->nombre));
        $prefijo = (count($nombreDividido) > 1)
            ? strtoupper(substr($nombreDividido[0], 0, 1) . substr($nombreDividido[1], 0, 1))
            : strtoupper(substr($tipo->nombre, 0, 2));

        // Asegurar que el nick_apodo esté limpio (sin espacios innecesarios)
        $nick = trim($nickApodo);

        return $prefijo . '-' . $nick;
    }

    public function edit($id)
    {
        $asociado = Associate::with('tipoEntidad', 'correos')->findOrFail($id);
        $tiposAsociados = AssociateType::all(); // Obtener todos los tipos de asociados

        return view('entities_section.entity_types.associated_trading.edit', compact('asociado', 'tiposAsociados'));
    }

    public function update(Request $request, $id)
    {
        $asociado = Associate::findOrFail($id);

        // Validar datos
        $request->validate([
            'nick_apodo' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|regex:/^\d{9,15}$/',
            'correo_recuperacion' => 'nullable|email|max:255',
            'tipos_asociados' => 'sometimes|array',
            'tipos_asociados.*' => 'exists:tipo_asociado,id',
            'estado_asociado' => 'nullable|string|in:activo,inactivo',

            'correo_ids'          => 'sometimes|array',
            'correo_ids.*'        => 'nullable|integer|exists:correos_asociados,id',
            'correos'             => 'sometimes|array',
            'correos.*'           => 'nullable|email',
            'passwords'           => 'sometimes|array',
            'passwords.*'         => 'nullable|string|min:6',
        ]);

        // Guardar el antiguo nick para comparar
        $nickAnterior = $asociado->nick_apodo;

        // Actualizar datos básicos
        $asociado->update([
            'nick_apodo' => $request->nick_apodo,
            'telefono' => $request->telefono,
            'correo_recuperacion' => $request->correo_recuperacion,
        ]);

        // ✅ Actualizar solo los correos existentes
        if ($request->filled('correo_ids')) {
            foreach ($request->correo_ids as $index => $correoId) {
                $correo = $request->correos[$index] ?? null;
                $password = $request->passwords[$index] ?? null;

                if ($correo) {
                    $asociado->correos()->where('id', $correoId)->update([
                        'correo'   => $correo,
                        'password' => $password,
                    ]);
                }
            }
        }

        // ACTUALIZAR ESTADO DEL ASOCIADO EN `tipo_entidades`
        $tipoEntidad = $asociado->tipoEntidad;
        $estadoAsociado = $request->estado_asociado === 'activo' ? 'activo' : 'inactivo';
        $fechaBaja = $estadoAsociado === 'inactivo' ? now() : null;

        $tipoEntidad->update([
            'estado' => $estadoAsociado,
            'fecha_baja' => $fechaBaja,
        ]);

        // Si se desactiva el asociado, también desactivar sus tipos asociados
        if ($estadoAsociado === 'inactivo') {
            $asociado->tiposAsociados()->update([
                'estado' => 'inactivo',
                'fecha_baja' => now(),
            ]);
        }

        // 🔹 Si se activa nuevamente, NO activar los tipos asociados, pero limpiar fecha_baja
        if ($estadoAsociado === 'activo') {
            $tipoEntidad->update(['fecha_baja' => null]);
            $asociado->tiposAsociados()->update(['fecha_baja' => null]); // Solo limpiar fecha_baja, no activar
        }

        // Actualizar los tipos de asociados (solo estado, NO eliminar)
        $this->actualizarEstadoTiposAsociado($asociado, $request->tipos_asociados ?? []);

        // Si `nick_apodo` cambió, actualizar `code_sistema` en `asociado_tipo_asociado`
        if ($nickAnterior !== $request->nick_apodo) {
            $this->actualizarCodeSistema($asociado, $request->nick_apodo);
        }

        return redirect()->route('asociado_trading.index')->with('success', 'Asociado actualizado correctamente.');
    }

    // Actualiza solo el estado de los tipos de asociado existentes.
    private function actualizarEstadoTiposAsociado(Associate $asociado, array $tiposSeleccionados)
    {
        foreach ($asociado->tiposAsociados as $tipoAsociado) {
            $estado = in_array($tipoAsociado->tipo_asociado_id, $tiposSeleccionados) ? 'activo' : 'inactivo';

            // Solo actualizar si el estado realmente cambió
            if ($tipoAsociado->estado !== $estado) {
                $tipoAsociado->update([
                    'estado' => $estado,
                    'fecha_baja' => $estado === 'inactivo' ? now() : null, // Actualiza fecha si se desactiva
                ]);
            }
        }
    }

    // Si `nick_apodo` cambia, actualiza `code_sistema` en `asociado_tipo_asociado`.
    private function actualizarCodeSistema(Associate $asociado, $nuevoNick)
    {
        foreach ($asociado->tiposAsociados as $tipoAsociado) {
            // Obtener solo las dos primeras letras del code_tipo
            $prefijo = substr($tipoAsociado->code_tipo, 0, 2);

            // Generar el nuevo code_sistema usando solo el prefijo y el nick_apodo
            $nuevoCodeSistema = $prefijo . '-' . $nuevoNick;

            // Actualizar en la base de datos
            $tipoAsociado->update([
                'code_sistema' => $nuevoCodeSistema
            ]);
        }
    }
}
