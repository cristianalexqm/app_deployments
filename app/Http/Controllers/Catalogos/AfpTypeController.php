<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AfpType;
use Inertia\Inertia;

class AfpTypeController extends Controller
{
    public function index()
    {
        $afpTypes = AfpType::all();
        return Inertia::render('catalogos/afp_types/index', compact('afpTypes'));
    }

    public function create()
    {
        return Inertia::render('catalogos/afp_types/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:tipo_afp,code',
            'nombre' => 'required|string|max:100',
        ]);

        AfpType::create($request->all());

        return redirect()->route('afp_types.index')->with('success', 'Tipo de AFP creado correctamente.');
    }

    public function edit(AfpType $afpType)
    {
        return Inertia::render('catalogos/afp_types/edit', compact('afpType'));
    }

    public function update(Request $request, AfpType $afpType)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:tipo_afp,code,' . $afpType->id,
            'nombre' => 'required|string|max:100',
        ]);

        $afpType->update($request->all());

        return redirect()->route('afp_types.index')->with('success', 'Tipo de AFP actualizado.');
    }

    public function destroy(AfpType $afpType)
    {
        $afpType->delete();
        return redirect()->route('afp_types.index')->with('success', 'Tipo de AFP eliminado.');
    }
}
