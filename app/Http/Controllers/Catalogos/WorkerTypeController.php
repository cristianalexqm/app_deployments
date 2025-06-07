<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkerType;
use Inertia\Inertia;

class WorkerTypeController extends Controller
{
    public function index()
    {
        $workerTypes = WorkerType::all();
        return Inertia::render('catalogos/worker_types/index', compact('workerTypes'));
    }

    public function create()
    {
        return Inertia::render('catalogos/worker_types/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:tipo_trabajador,code',
            'nombre' => 'required|string|max:100',
        ]);

        WorkerType::create($request->all());

        return redirect()->route('worker_types.index')->with('success', 'Tipo de trabajador creado correctamente.');
    }

    public function edit(WorkerType $workerType)
    {
        return Inertia::render('catalogos/worker_types/edit', compact('workerType'));
    }

    public function update(Request $request, WorkerType $workerType)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:tipo_trabajador,code,' . $workerType->id,
            'nombre' => 'required|string|max:100',
        ]);

        $workerType->update($request->all());

        return redirect()->route('worker_types.index')->with('success', 'Tipo de trabajador actualizado.');
    }

    public function destroy(WorkerType $workerType)
    {
        $workerType->delete();
        return redirect()->route('worker_types.index')->with('success', 'Tipo de trabajador eliminado.');
    }
}
