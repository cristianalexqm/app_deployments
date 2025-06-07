<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\AccountTypeBanks;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountTypeBanksController extends Controller
{
    /**
     * Mostrar la lista de tipos de cuentas bancarias.
     */
    public function index()
    {
        $tipos_cuentas = AccountTypeBanks::all();
        return Inertia::render('catalogos/account_types_banks/index', compact('tipos_cuentas'));
    }

    /**
     * Mostrar el formulario para crear un nuevo tipo de cuenta.
     */
    public function create()
    {
        return Inertia::render('catalogos/account_types_banks/create');
    }

    /**
     * Guardar un nuevo tipo de cuenta en la base de datos.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cod' => 'required|string|max:10|unique:tipos_cuentas_bancos,cod',
            'tipo_cuenta' => 'required|string|max:50',
        ]);

        AccountTypeBanks::create($data);

        return redirect()->route('account_types_banks.index')->with('success', 'Tipo de cuenta banco creado exitosamente.');
    }

    /**
     * Mostrar el formulario de edición de un tipo de cuenta bancaria.
     */
    public function edit($id)
    {
        $tipo_cuenta = AccountTypeBanks::findOrFail($id);
        return Inertia::render('catalogos/account_types_banks/edit', compact('tipo_cuenta'));
    }

    /**
     * Actualizar un tipo de cuenta en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'cod' => "required|string|max:10|unique:tipos_cuentas_bancos,cod,{$id}",
            'tipo_cuenta' => 'required|string|max:50',
            'estado' => 'required|boolean',
        ]);

        $tipo_cuenta = AccountTypeBanks::findOrFail($id);
        $tipo_cuenta->update($data);

        return redirect()->route('account_types_banks.index')->with('success', 'Tipo de cuenta banco actualizado correctamente.');
    }

    /**
     * Eliminar un tipo de cuenta de la base de datos.
     */
    public function destroy($id)
    {
        $tipo_cuenta = AccountTypeBanks::findOrFail($id);
        $tipo_cuenta->delete(); // Elimina completamente el registro

        return redirect()->route('account_types_banks.index')->with('success', 'Tipo de cuenta banco eliminado correctamente.');
    }
}
