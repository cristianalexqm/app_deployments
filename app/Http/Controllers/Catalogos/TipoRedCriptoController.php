<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\TipoRedCripto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TipoRedCriptoController extends Controller
{
    // ✅ Mostrar todas las redes cripto
    public function index()
    {
        $redes = TipoRedCripto::all();
        return Inertia::render('catalogos/tipo_red_cripto/index', compact('redes'));
    }

    // ✅ Mostrar formulario para crear una nueva red cripto
    public function create()
    {
        return Inertia::render('catalogos/tipo_red_cripto/create');
    }

    // ✅ Guardar nueva red cripto
    public function store(Request $request)
    {
        $request->validate([
            'cod' => 'required|string|max:20|unique:tipo_red_criptos,cod',
            'red' => 'required|string|max:50',
        ]);

        $data = $request->all();

        TipoRedCripto::create($data);

        return redirect()->route('tipo_red_cripto.index')->with('success', 'Red cripto creada correctamente.');
    }

    // ✅ Mostrar formulario para editar una red cripto existente
    public function edit($id)
    {
        $tipoRedCripto = TipoRedCripto::findOrFail($id);
        return Inertia::render('catalogos/tipo_red_cripto/edit', compact('tipoRedCripto'));
    }

    // ✅ Actualizar una red cripto existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'cod' => 'sometimes|string|max:20|unique:tipo_red_criptos,cod,' . $id,
            'red' => 'sometimes|string|max:50',
            'estado' => 'required|boolean',
        ]);

        $tipoRedCripto = TipoRedCripto::findOrFail($id);

        $data = $request->all();

        $tipoRedCripto->update($data);

        return redirect()->route('tipo_red_cripto.index')->with('success', 'Red cripto actualizada correctamente.');
    }

    // ✅ Eliminar una red cripto
    public function destroy($id)
    {
        $tipoRedCripto = TipoRedCripto::findOrFail($id);
        $tipoRedCripto->delete();

        return redirect()->route('tipo_red_cripto.index')->with('success', 'Red cripto eliminada correctamente.');
    }
}
