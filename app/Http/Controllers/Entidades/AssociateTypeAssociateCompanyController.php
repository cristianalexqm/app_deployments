<?php

namespace App\Http\Controllers\Entidades;

use App\Http\Controllers\Controller;
use App\Models\AssociateTypeAssociateCompany;
use Illuminate\Http\Request;

class AssociateTypeAssociateCompanyController extends Controller
{
    /**
     * Almacenar una nueva relación empresa - asociado+tipo
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'associate_type_associate_id' => 'required|exists:asociado_tipo_asociado,id',
            'own_company_id' => 'required|exists:empresa_propia,id',
            'estado' => 'required|boolean',
        ]);

        // Verificar si ya existe la relación
        $exists = AssociateTypeAssociateCompany::where('associate_type_associate_id', $validated['associate_type_associate_id'])
            ->where('own_company_id', $validated['own_company_id'])
            ->exists();

        // dd($exists->all());

        if ($exists) {
            return back()->with('error', 'Esta relación ya existe.');
        }

        AssociateTypeAssociateCompany::create($validated);

        return back()->with('success', 'Empresa asignada correctamente.');
    }

    /**
     * Cambiar el estado (activo/inactivo) de la relación
     */
    public function update(Request $request, AssociateTypeAssociateCompany $associateTypeAssociateCompany)
    {
        $validated = $request->validate([
            'estado' => 'required|boolean',
        ]);

        $associateTypeAssociateCompany->update(['estado' => $validated['estado']]);

        return back()->with('success-estado', 'Estado actualizado correctamente.');
    }

    /**
     * Eliminar una asignación empresa - asociado+tipo
     */
    public function destroy(AssociateTypeAssociateCompany $associateTypeAssociateCompany)
    {
        $associateTypeAssociateCompany->delete();

        return back()->with('success-destroy', 'Empresa desvinculada correctamente.');
    }

    // Métodos no implementados
    public function index() {}
    public function create() {}
    public function show(AssociateTypeAssociateCompany $associateTypeAssociateCompany) {}
    public function edit(AssociateTypeAssociateCompany $associateTypeAssociateCompany) {}
}
