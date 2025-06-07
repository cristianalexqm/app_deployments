<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AfpCommissionType;
use Inertia\Inertia;

class AfpCommissionTypeController extends Controller
{
    public function index()
    {
        $afpCommissionTypes = AfpCommissionType::all();
        return Inertia::render('catalogos/afp_commission_types/index', compact('afpCommissionTypes'));
    }

    public function create()
    {
        return Inertia::render('catalogos/afp_commission_types/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:tipo_comision_afp,code',
            'nombre' => 'required|string|max:100',
        ]);

        AfpCommissionType::create($request->all());

        return redirect()->route('afp_commission_types.index')->with('success', 'Tipo de comisión de AFP creado correctamente.');
    }

    public function edit(AfpCommissionType $afpCommissionType)
    {
        return Inertia::render('catalogos/afp_commission_types/edit', compact('afpCommissionType'));
    }

    public function update(Request $request, AfpCommissionType $afpCommissionType)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:tipo_comision_afp,code,' . $afpCommissionType->id,
            'nombre' => 'required|string|max:100',
        ]);

        $afpCommissionType->update($request->all());

        return redirect()->route('afp_commission_types.index')->with('success', 'Tipo de comisión de AFP actualizado.');
    }

    public function destroy(AfpCommissionType $afpCommissionType)
    {
        $afpCommissionType->delete();
        return redirect()->route('afp_commission_types.index')->with('success', 'Tipo de comisión de AFP eliminado.');
    }
}
