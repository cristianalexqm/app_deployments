<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\AccountClass;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountClassController extends Controller
{
    /**
     * Muestra la lista de clases de cuentas.
     */
    public function index()
    {
        $clases_cuentas = AccountClass::all();
        return Inertia::render('catalogos/account_classes/index', compact('clases_cuentas'));
    }

    /**
     * Muestra el formulario para crear una nueva clase de cuenta.
     */
    public function create()
    {
        return Inertia::render('catalogos/account_classes/create');
    }

    /**
     * Guarda una nueva clase de cuenta en la base de datos.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cod' => 'required|string|max:10|unique:clases_cuentas,cod',
            'tipo_clase_cuenta' => 'required|string|max:50',
        ]);

        AccountClass::create($data);

        return redirect()->route('account_classes.index')->with('success', 'Clase de cuenta creada exitosamente.');
    }

    /**
     * Muestra el formulario de edición de una clase de cuenta.
     */
    public function edit($id)
    {
        $clase = AccountClass::findOrFail($id);
        return Inertia::render('catalogos/account_classes/edit', compact('clase'));
    }

    /**
     * Actualiza una clase de cuenta en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'cod' => 'required|string|max:10|unique:clases_cuentas,cod,' . $id,
            'tipo_clase_cuenta' => 'required|string|max:50',
            'estado' => 'required|boolean',
        ]);

        $clase = AccountClass::findOrFail($id);
        $clase->update($data);

        return redirect()->route('account_classes.index')->with('success', 'Clase de cuenta actualizada correctamente.');
    }

    /**
     * Desactiva una clase de cuenta en la base de datos.
     */
    public function destroy($id)
    {
        $clase = AccountClass::findOrFail($id);
        $clase->delete();
        return redirect()->route('account_classes.index')->with('success', 'Clase de cuenta eliminada correctamente.');
    }
}
