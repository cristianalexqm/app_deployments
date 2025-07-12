<?php

namespace App\Http\Controllers\Entidades;

use App\Http\Controllers\Controller;
use App\Models\BankType;
use App\Models\EntityType;
use App\Models\Provider;
use App\Models\Client;
use App\Models\Entity;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        // ✅ Capturar valor de per_page desde el request (por defecto 10)
        $perPage = $request->input('per_page', 10);

        // 1️⃣ Obtener entidades que tienen el tipo 'Proveedor' (tipo_id = 2)
        $entities = Entity::whereHas('tiposEntidades', function ($query) {
            $query->where('tipo_id', 2); // 🔹 Solo proveedores
        })
            ->with([
                'tipoDocumento',
                'tiposEntidades' => function ($query) {
                    $query->where('tipo_id', 2); // 🔹 Filtrar solo los tipos de proveedores
                },
                'tiposEntidades.tipo',
                'tiposEntidades.proveedor', // Relación con el proveedor
                'persona',
                'empresa'
            ])
            ->orderBy('id', 'asc') // Ordenar por ID
            ->paginate($perPage); // 📌 Agregamos paginación

        // 2️⃣ Obtener el proveedor seleccionado (Por defecto, el primero en la lista)
        $selectedEntity = $entities->first();

        // 3️⃣ Si el usuario seleccionó una entidad específica, la obtenemos
        if ($request->has('selected')) {
            $selectedEntity = Entity::whereHas('tiposEntidades', function ($query) {
                $query->where('tipo_id', 2); // 🔹 Solo proveedores
            })
                ->with([
                    'tipoDocumento',
                    'tiposEntidades' => function ($query) {
                        $query->where('tipo_id', 2); // 🔹 Solo proveedores
                    },
                    'tiposEntidades.tipo',
                    'tiposEntidades.proveedor', // Relación con proveedor
                    'persona',
                    'empresa'
                ])
                ->find($request->selected);
        }

        // 4️⃣ Devolver la vista con los proveedores filtrados
        return view('entities_section.entity_types.provider_types.index', compact('entities', 'selectedEntity'));
    }

    public function store(Request $request, $entityId)
    {
        $request->validate([
            'tipo_banco_id' => 'required|exists:tipos_bancos,id',
            'cuenta_bancaria' => 'required|string|regex:/^[0-9]{10,20}$/',
            'aval' => 'nullable|string|max:50',
        ]);

        // Buscar el tipo de entidad para Proveedor
        $tipoEntidad = EntityType::where('entidad_id', $entityId)->where('tipo_id', 2)->firstOrFail();

        // Buscar si ya existe como Cliente
        $cliente = Client::where('dato_extra_tipo_entidad_id', $tipoEntidad->id)->first();

        if ($cliente) {
            // Si ya existe como Cliente, usar sus datos
            $proveedorData = [
                'tipo_banco_id' => $cliente->tipo_banco_id,
                'cuenta_bancaria' => $cliente->cuenta_bancaria,
                'aval' => $cliente->aval,
            ];
        } else {
            // Si no existe, usar los datos ingresados en el formulario
            $proveedorData = $request->only(['tipo_banco_id', 'cuenta_bancaria', 'aval']);
        }

        try {
            Provider::create(array_merge(['dato_extra_tipo_entidad_id' => $tipoEntidad->id], $proveedorData));

            return redirect()->back()->with('success', 'Proveedor: Los datos adicionales para la entidad han sido registrados correctamente.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error: La entidad seleccionada ya tiene datos adicionales asignados. Solo se permite un registro por entidad.');
        }
    }

    public function edit($id)
    {
        // ✅ Buscar el proveedor
        $proveedor = Provider::findOrFail($id);

        // ✅ Obtener el entidad_id desde tipo_entidades
        $entidadId = $proveedor->tipoEntidad->entidad_id ?? null;

        // ✅ Buscar si la misma entidad tiene un tipo Cliente en tipo_entidades
        $cliente = Client::whereHas('tipoEntidad', function ($query) use ($entidadId) {
            $query->where('entidad_id', $entidadId);
        })->first();

        // ✅ Obtener datos para selects
        $bancos = BankType::all();

        return view('entities_section.entity_types.provider_types.edit', compact('proveedor', 'cliente', 'bancos'));
    }


    public function update(Request $request, $id)
    {
        // ✅ Validar datos de entrada
        $request->validate([
            'tipo_banco_id' => 'nullable|exists:tipos_bancos,id',
            'cuenta_bancaria' => 'nullable|string|max:50',
            'aval' => 'nullable|string|max:255'
        ]);

        // ✅ Buscar el proveedor
        $proveedor = Provider::findOrFail($id);

        // ✅ Obtener el entidad_id desde tipo_entidades
        $entidadId = $proveedor->tipoEntidad->entidad_id ?? null;

        // ✅ Buscar si hay un cliente asociado a la misma entidad
        $cliente = Client::whereHas('tipoEntidad', function ($query) use ($entidadId) {
            $query->where('entidad_id', $entidadId);
        })->first();

        // ✅ Actualizar proveedor
        $proveedor->update($request->only(['tipo_banco_id', 'cuenta_bancaria', 'aval']));

        // ✅ Si también es cliente, actualizarlo con los mismos datos
        if ($cliente) {
            $cliente->update($request->only(['tipo_banco_id', 'cuenta_bancaria', 'aval']));
        }

        // ✅ Redireccionar con mensaje de éxito
        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }
}
