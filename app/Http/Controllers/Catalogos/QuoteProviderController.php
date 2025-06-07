<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\QuoteProvider;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuoteProviderController extends Controller
{
    // Muestra una lista de los proveedores de cuota.
    public function index()
    {
        $providers = QuoteProvider::all(); // Obtener todos los proveedores
        return Inertia::render('catalogos/quote_providers/index', compact('providers'));
    }

    // Muestra el formulario para crear un nuevo proveedor de cuota.
    public function create()
    {
        return Inertia::render('catalogos/quote_providers/create');
    }

    // Guarda un nuevo proveedor de cuota en la base de datos.
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255|unique:proveedor_cuota,nombre',
                'descripcion' => 'nullable|string|max:225',
            ]);

            QuoteProvider::create($request->all());

            return redirect()->route('quote_providers.index')->with('success', 'Proveedor de cuota creado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'El nombre del proveedor ya está registrado. Por favor, elige otro nombre.');
        }
    }

    // Muestra el formulario para editar un proveedor de cuota.
    public function edit(QuoteProvider $quoteProvider)
    {
        return Inertia::render('catalogos/quote_providers/edit', compact('quoteProvider'));
    }

    // Actualiza el proveedor de cuota en la base de datos.
    public function update(Request $request, QuoteProvider $quoteProvider)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255|unique:proveedor_cuota,nombre,' . $quoteProvider->id,
                'descripcion' => 'nullable|string|max:225',
            ]);

            $quoteProvider->update($request->all());

            return redirect()->route('quote_providers.index')->with('success', 'Proveedor de cuota actualizado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'El nombre del proveedor ya está registrado. Por favor, elige otro nombre.');
        }
    }

    // Elimina un proveedor de cuota de la base de datos.
    public function destroy(QuoteProvider $quoteProvider)
    {
        $quoteProvider->delete();

        return redirect()->route('quote_providers.index')->with('success', 'Proveedor de cuota eliminado correctamente.');
    }
}
