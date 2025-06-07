<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\CardType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CardTypeController extends Controller
{
    /**
     * Mostrar la lista de tipos de tarjetas.
     */
    public function index()
    {
        $tipos_tarjetas = CardType::all();
        return Inertia::render('catalogos/card_types/index', compact('tipos_tarjetas'));
    }

    /**
     * Mostrar el formulario de creación de un nuevo tipo de tarjeta.
     */
    public function create()
    {
        return Inertia::render('catalogos/card_types/create');
    }

    /**
     * Guardar un nuevo tipo de tarjeta en la base de datos.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cod' => 'required|string|max:10|unique:tipos_tarjetas,cod',
            'emisor' => 'required|string|max:50',
        ]);

        CardType::create($data);

        return redirect()->route('card_types.index')->with('success', 'Tipo de tarjeta creado exitosamente.');
    }

    /**
     * Mostrar el formulario de edición de un tipo de tarjeta.
     */
    public function edit($id)
    {
        $tarjeta = CardType::findOrFail($id);
        return Inertia::render('catalogos/card_types/edit', compact('tarjeta'));
    }

    /**
     * Actualizar un tipo de tarjeta en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'cod' => "required|string|max:10|unique:tipos_tarjetas,cod,{$id}",
            'emisor' => 'required|string|max:50',
            'estado' => 'required|boolean',
        ]);

        $tarjeta = CardType::findOrFail($id);
        $tarjeta->update($data);

        return redirect()->route('card_types.index')->with('success', 'Tipo de tarjeta actualizado correctamente.');
    }

    /**
     * Eliminar un tipo de tarjeta de la base de datos.
     */
    public function destroy($id)
    {
        $tarjeta = CardType::findOrFail($id);
        $tarjeta->delete();

        return redirect()->route('card_types.index')->with('success', 'Tipo de tarjeta eliminado correctamente.');
    }
}
