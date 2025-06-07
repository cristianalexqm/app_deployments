<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\MobileOperator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MobileOperatorController extends Controller
{
    /**
     * Mostrar la lista de operadores móviles.
     */
    public function index()
    {
        $operadores = MobileOperator::all();
        return Inertia::render('catalogos/mobile_operators/index', compact('operadores'));
    }

    /**
     * Mostrar el formulario de creación de un nuevo operador móvil.
     */
    public function create()
    {
        return Inertia::render('catalogos/mobile_operators/create');
    }

    /**
     * Guardar un nuevo operador móvil en la base de datos.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cod' => 'required|string|max:10|unique:operadores_moviles,cod',
            'operador' => 'required|string|max:50',
        ]);

        MobileOperator::create($data);

        return redirect()->route('mobile_operators.index')->with('success', 'Operador creado exitosamente.');
    }

    /**
     * Mostrar el formulario de edición de un operador móvil.
     */
    public function edit($id)
    {
        $operador = MobileOperator::findOrFail($id);
        return Inertia::render('catalogos/mobile_operators/edit', compact('operador'));
    }

    /**
     * Actualizar un operador móvil en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'cod' => "required|string|max:10|unique:operadores_moviles,cod,{$id}",
            'operador' => 'required|string|max:50',
            'estado' => 'required|boolean',
        ]);

        $operador = MobileOperator::findOrFail($id);
        $operador->update($data);

        return redirect()->route('mobile_operators.index')->with('success', 'Operador actualizado correctamente.');
    }

    /**
     * Eliminar un operador móvil de la base de datos.
     */
    public function destroy($id)
    {
        $operador = MobileOperator::findOrFail($id);
        $operador->delete();

        return redirect()->route('mobile_operators.index')->with('success', 'Operador eliminado correctamente.');
    }
}
