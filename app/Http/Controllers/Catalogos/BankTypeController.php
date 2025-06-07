<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\AccountTypeBanks;
use App\Models\BankType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BankTypeController extends Controller
{
    /**
     * Mostrar la lista de tipos de bancos.
     */
    public function index()
    {
        $tipos_bancos = BankType::with(['tipoCuentaBanco'])->get();
        return Inertia::render('catalogos/bank_types/index', compact('tipos_bancos'));
    }

    /**
     * Mostrar el formulario de creación de un nuevo tipo de banco.
     */
    public function create()
    {
        // Definimos los valores del ENUM para mostrar en la vista
        $tipos_recurso = ["FIAT", "CRIPTO", "BILLETERA"];

        // Obtenemos todos los tipos de cuentas para mostrarlos en el formulario
        $tipos_cuentas = AccountTypeBanks::all();
        return Inertia::render('catalogos/bank_types/create', compact('tipos_recurso', 'tipos_cuentas'));
    }

    /**
     * Guardar un nuevo tipo de banco en la base de datos.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cod' => 'required|string|max:10|unique:tipos_bancos,cod',
            'tipo_banco' => 'required|string|max:50',
            'tipo_recurso' => 'required|in:FIAT,CRIPTO,BILLETERA', // Validación del ENUM
            'tipos_cuentas_bancos_id' => 'required|exists:tipos_cuentas_bancos,id', // Clave foránea
        ]);

        BankType::create($data);

        return redirect()->route('bank_types.index')->with('success', 'Tipo de banco creado exitosamente.');
    }

    /**
     * Mostrar el formulario de edición de un tipo de banco.
     */
    public function edit($id)
    {
        $tipo_banco = BankType::findOrFail($id);
        $tipos_recurso = ["FIAT", "CRIPTO", "BILLETERA"]; // ENUM para la vista
        $tipos_cuentas = AccountTypeBanks::all();
        return Inertia::render('catalogos/bank_types/edit', compact('tipo_banco', 'tipos_recurso', 'tipos_cuentas'));
    }

    /**
     * Actualizar un tipo de banco en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'cod' => "required|string|max:10|unique:tipos_bancos,cod,{$id}",
            'tipo_banco' => 'required|string|max:50',
            'tipo_recurso' => 'required|in:FIAT,CRIPTO,BILLETERA', // Validación del ENUM
            'tipos_cuentas_bancos_id' => 'required|exists:tipos_cuentas_bancos,id', // Validación de la clave foránea
            'estado' => 'required|boolean',
        ]);

        $tipo_banco = BankType::findOrFail($id);
        $tipo_banco->update($data);

        return redirect()->route('bank_types.index')->with('success', 'Tipo de banco actualizado correctamente.');
    }

    /**
     * Eliminar un tipo de banco de la base de datos.
     */
    public function destroy($id)
    {
        $tipo_banco = BankType::findOrFail($id);
        $tipo_banco->delete(); // Elimina el registro de la base de datos

        return redirect()->route('bank_types.index')->with('success', 'Tipo de banco eliminado correctamente.');
    }
}
