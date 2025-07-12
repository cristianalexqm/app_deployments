<?php

namespace App\Http\Controllers\Entidades;

use App\Http\Controllers\Controller;
use App\Models\BankType;
use App\Models\Client;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Provider;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        // ✅ Capturar valor de per_page desde el request (por defecto 10)
        $perPage = $request->input('per_page', 10);

        // 1️⃣ Obtener entidades que tienen el tipo "Cliente" (tipo_id = 3)
        $entities = Entity::whereHas('tiposEntidades', function ($query) {
            $query->where('tipo_id', 3); // 🔹 Solo clientes
        })
            ->with([
                'tipoDocumento',
                'tiposEntidades' => function ($query) {
                    $query->where('tipo_id', 3); // 🔹 Filtrar solo los tipos de cliente
                },
                'tiposEntidades.tipo',
                'tiposEntidades.cliente',
                'persona',
                'empresa'
            ])
            ->paginate($perPage); // 📌 Agregamos paginación

        // 2️⃣ Obtener el cliente seleccionado (Por defecto, el primero en la lista)
        $selectedEntity = $entities->first();

        // 3️⃣ Si el usuario seleccionó una entidad específica, la obtenemos
        if ($request->has('selected')) {
            $selectedEntity = Entity::whereHas('tiposEntidades', function ($query) {
                $query->where('tipo_id', 3); // 🔹 Solo clientes
            })
                ->with([
                    'tipoDocumento',
                    'tiposEntidades' => function ($query) {
                        $query->where('tipo_id', 3); // 🔹 Solo clientes
                    },
                    'tiposEntidades.tipo',
                    'tiposEntidades.cliente',
                    'persona',
                    'empresa'
                ])
                ->find($request->selected);
        }

        // 4️⃣ Devolver la vista con los clientes filtrados
        return view('entities_section.entity_types.client_types.index', compact('entities', 'selectedEntity'));
    }

    public function store(Request $request, $entityId)
    {
        $request->validate([
            'tipo_banco_id' => 'required|exists:tipos_bancos,id',
            'cuenta_bancaria' => 'required|string|regex:/^[0-9]{10,20}$/',
            'aval' => 'nullable|string|max:50',
        ]);

        // Buscar el tipo de entidad para Cliente
        $tipoEntidad = EntityType::where('entidad_id', $entityId)->where('tipo_id', 3)->firstOrFail();

        // Buscar si ya existe como Proveedor
        $proveedor = Provider::where('dato_extra_tipo_entidad_id', $tipoEntidad->id)->first();

        if ($proveedor) {
            // Si ya existe como Proveedor, usar sus datos
            $clienteData = [
                'tipo_banco_id' => $proveedor->tipo_banco_id,
                'cuenta_bancaria' => $proveedor->cuenta_bancaria,
                'aval' => $proveedor->aval,
            ];
        } else {
            // Si no existe, usar los datos ingresados en el formulario
            $clienteData = $request->only(['tipo_banco_id', 'cuenta_bancaria', 'aval']);
        }

        try {
            Client::create(array_merge(['dato_extra_tipo_entidad_id' => $tipoEntidad->id], $clienteData));

            return redirect()->back()->with('success', 'Cliente: Los datos adicionales para la entidad han sido registrados correctamente.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error: La entidad seleccionada ya tiene datos adicionales asignados. Solo se permite un registro por entidad.');
        }
    }

    public function edit($id)
    {
        // ✅ Buscar el cliente por ID
        $cliente = Client::findOrFail($id);

        // ✅ Obtener el entidad_id desde tipo_entidades
        $entidadId = $cliente->tipoEntidad->entidad_id ?? null;

        // ✅ Buscar si la misma entidad tiene un tipo Proveedor en tipo_entidades
        $proveedor = Provider::whereHas('tipoEntidad', function ($query) use ($entidadId) {
            $query->where('entidad_id', $entidadId);
        })->first();

        // ✅ Obtener datos para selects
        $bancos = BankType::all();

        return view('entities_section.entity_types.client_types.edit', compact('cliente', 'proveedor', 'bancos'));
    }

    public function update(Request $request, $id)
    {
        // ✅ Validar datos de entrada
        $request->validate([
            'tipo_banco_id' => 'nullable|exists:tipos_bancos,id',
            'cuenta_bancaria' => 'nullable|string|max:50',
            'aval' => 'nullable|string|max:255'
        ]);

        // ✅ Buscar el cliente por ID
        $cliente = Client::findOrFail($id);

        // ✅ Obtener el entidad_id desde tipo_entidades
        $entidadId = $cliente->tipoEntidad->entidad_id ?? null;

        // ✅ Buscar si hay un proveedor asociado a la misma entidad
        $proveedor = Provider::whereHas('tipoEntidad', function ($query) use ($entidadId) {
            $query->where('entidad_id', $entidadId);
        })->first();

        // ✅ Actualizar cliente
        $cliente->update($request->only(['tipo_banco_id', 'cuenta_bancaria', 'aval']));

        // ✅ Si también es proveedor, actualizarlo con los mismos datos
        if ($proveedor) {
            $proveedor->update($request->only(['tipo_banco_id', 'cuenta_bancaria', 'aval']));
        }

        // ✅ Redireccionar con mensaje de éxito
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }
}
