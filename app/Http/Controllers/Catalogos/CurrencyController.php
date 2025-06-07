<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CurrencyController extends Controller
{
    /**
     * Mostrar la lista de monedas.
     */
    public function index()
    {
        $monedas = Currency::all();
        return Inertia::render('catalogos/currencies/index', compact('monedas'));
    }

    /**
     * Mostrar el formulario de creación de una nueva moneda.
     */
    public function create()
    {
        $naturalezas = ['tangible', 'digital']; // Opciones del ENUM
        return Inertia::render('catalogos/currencies/create', ['naturalezas' => $naturalezas,]);
    }

    /**
     * Guardar una nueva moneda en la base de datos.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cod' => 'required|string|max:10|unique:monedas,cod',
            'moneda' => 'required|string|max:50',
            'naturaleza' => 'required|in:tangible,digital', // Validación del ENUM
        ]);

        Currency::create($data);

        return redirect()->route('currencies.index')->with('success', 'Moneda creada exitosamente.');
    }

    /**
     * Mostrar el formulario de edición de una moneda.
     */
    public function edit($id)
    {
        $moneda = Currency::findOrFail($id);
        $naturalezas = ['tangible', 'digital']; // Opciones del ENUM
        return Inertia::render('catalogos/currencies/edit', compact('moneda', 'naturalezas'));
    }

    /**
     * Actualizar una moneda en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'cod' => "required|string|max:10|unique:monedas,cod,{$id}",
            'moneda' => 'required|string|max:50',
            'naturaleza' => 'required|in:tangible,digital', // Validación del ENUM
            'estado' => 'required|boolean',
        ]);

        $moneda = Currency::findOrFail($id);
        $moneda->update($data);

        return redirect()->route('currencies.index')->with('success', 'Moneda actualizada correctamente.');
    }

    /**
     * Eliminar una moneda de la base de datos.
     */
    public function destroy($id)
    {
        $moneda = Currency::findOrFail($id);
        $moneda->delete();

        return redirect()->route('currencies.index')->with('success', 'Moneda eliminada correctamente.');
    }
}
