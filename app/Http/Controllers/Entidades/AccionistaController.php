<?php

namespace App\Http\Controllers\Entidades;

use App\Http\Controllers\Controller;
use App\Models\EntityType;
use App\Models\ShareholderOwnCompany;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AccionistaController extends Controller
{
    public function index(Request $request)
    {
        // ✅ Capturar valor de per_page desde el request (por defecto 10)
        $perPage = $request->input('per_page', 10);

        $entities = EntityType::where('tipo_id', 6)
            ->select(['id', 'code', 'estado', 'entidad_id'])
            ->with([
                // Datos de los accionistas
                'accionistaEmpresaPropia:id,nro_acciones,porcentaje_acciones,empresa_propia_id,tipo_entidad_id,fecha_desde,fecha_hasta',

                // Datos de la entidad del accionista
                'entidad',
                'entidad.tipoDocumento:id,code',
                'entidad.persona',
                'entidad.empresa',

                // Datos de la empresa propia del accionista
                'accionistaEmpresaPropia.empresaPropia:id,representante_legal,dato_extra_tipo_entidad_id',

                // Datos del tipo de entidad de la empresa propia (para acceder a la entidad)
                'accionistaEmpresaPropia.empresaPropia.tipoEntidad:id,entidad_id',

                // Nombre de la empresa propia (relación hacia la entidad)
                'accionistaEmpresaPropia.empresaPropia.tipoEntidad.entidad:id,nombre_razon_social',
            ])
            ->paginate($perPage);

        /* dd($entities->toArray()['data']); */

        return view('entities_section.entity_types.shareholder_types.index', compact('entities'));
    }

    public function edit($id)
    {
        $accionista = EntityType::with([
            'accionistaEmpresaPropia.empresaPropia'
        ])->findOrFail($id);

        // 🔥 Obtener las empresas propias en las que el accionista tiene participación
        $empresas = $accionista->accionistaEmpresaPropia->pluck('empresaPropia')->filter()->map(function ($empresa) {
            $empresa->nombre_razon_social = $empresa->tipoEntidad->entidad->nombre_razon_social ?? 'N/A';
            return $empresa;
        });

        // 🔥 Pasar todas las relaciones accionista-empresa para usarlas en el frontend
        $accionistaEmpresas = $accionista->accionistaEmpresaPropia->map(function ($registro) {
            return [
                'empresa_propia_id' => $registro->empresa_propia_id,
                'nro_acciones' => $registro->nro_acciones,
                'porcentaje_acciones' => $registro->porcentaje_acciones,
                'fecha_desde' => $registro->fecha_desde,
                'fecha_hasta' => $registro->fecha_hasta
            ];
        });

        return view('entities_section.entity_types.shareholder_types.edit', compact('accionista', 'empresas', 'accionistaEmpresas'));
    }

    public function update(Request $request, $id)
    {
        $accionista = EntityType::with('accionistaEmpresaPropia')->findOrFail($id);

        // 🔥 Obtener solo las empresas propias en las que el accionista tiene acciones
        $empresasValidas = $accionista->accionistaEmpresaPropia->pluck('empresa_propia_id')->toArray();

        // Validaciones
        $request->validate([
            'empresa_propia_id' => [
                'required',
                Rule::in($empresasValidas), // Asegurar que la empresa seleccionada pertenece al accionista
            ],
            'nro_acciones' => 'required|integer|min:0',
            'porcentaje_acciones' => 'required|integer|min:0|max:100',
            'fecha_desde' => 'required|date',
            'fecha_hasta' => 'nullable|date|after_or_equal:fecha_desde',
        ]);

        // 🔥 Buscar la relación correcta en ShareholderOwnCompany
        $relacionAccionistaEmpresa = ShareholderOwnCompany::where('empresa_propia_id', $request->empresa_propia_id)
            ->where('tipo_entidad_id', $accionista->id)
            ->first();

        if (!$relacionAccionistaEmpresa) {
            return redirect()->back()->with('error', 'No se encontró la relación entre el accionista y la empresa seleccionada.');
        }

        // Actualizar datos en la tabla `accionista_empresa_propia`
        $relacionAccionistaEmpresa->update([
            'nro_acciones' => $request->nro_acciones,
            'porcentaje_acciones' => $request->porcentaje_acciones,
            'fecha_desde' => $request->fecha_desde,
            'fecha_hasta' => $request->fecha_hasta,
        ]);

        return redirect()->route('accionistas.index')->with('success', 'Accionista actualizado correctamente.');
    }
}
