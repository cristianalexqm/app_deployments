<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentType;
use Inertia\Inertia;

class DocumentTypeController extends Controller
{
    public function index()
    {
        $documentTypes = DocumentType::all();
        return Inertia::render('catalogos/document_types/index', compact('documentTypes'));
    }

    public function create()
    {
        return Inertia::render('catalogos/document_types/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|max:10|unique:tipo_documentos,code',
            'nombre' => 'required|max:50|unique:tipo_documentos,nombre',
        ]);

        DocumentType::create($request->all());
        return redirect()->route('document_types.index')->with('success', 'Tipo de documento creado correctamente.');
    }

    public function edit(DocumentType $documentType)
    {
        return Inertia::render('catalogos/document_types/edit', compact('documentType'));
    }

    public function update(Request $request, DocumentType $documentType)
    {
        $request->validate([
            'code' => 'required|max:10',
            'nombre' => 'required|max:50',
        ]);

        $documentType->update($request->all());
        return redirect()->route('document_types.index')->with('success', 'Tipo de documento actualizado correctamente.');
    }

    public function destroy(DocumentType $documentType)
    {
        $documentType->delete();
        return redirect()->route('document_types.index')->with('success', 'Tipo de documento eliminado.');
    }
}
