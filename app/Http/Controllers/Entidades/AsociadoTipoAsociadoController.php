<?php

namespace App\Http\Controllers\Entidades;

use App\Http\Controllers\Controller;
use App\Models\AssociateTypeAssociate;
use App\Models\AssociateType;
use App\Models\DocumentType;
use Illuminate\Http\Request;

class AsociadoTipoAsociadoController extends Controller
{
    public function index(Request $request)
    {
        // Capturar 
        $selectedAsociadoTipo = null;
        $perPage = $request->input('per_page', 10); // 10 por defecto

        // Query base con relaciones necesarias
        $query = AssociateTypeAssociate::with([
            'asociado.tipoEntidad.entidad.tipoDocumento',
            'asociado.tipoEntidad.entidad.persona',  // 🔹 Relación con Persona
            'asociado.tipoEntidad.entidad.empresa',  // 🔹 Relación con Empresa
            'tipoAsociado'
        ]);

        // Obtener el tipo de asociado seleccionado si se envía en la URL
        if ($request->has('selected')) {
            $selectedAsociadoTipo = AssociateTypeAssociate::with([
                'asociado.tipoEntidad.entidad.tipoDocumento',
                'asociado.tipoEntidad.entidad.persona',
                'asociado.tipoEntidad.entidad.empresa',
                'tipoAsociado'
            ])->find($request->selected);
        }

        // 📌 Paginar resultados con filtros aplicados
        $asociadosTipos = $query->paginate($perPage)->appends(request()->query());

        // 🔹 Obtener todos los tipos de asociados para los filtros
        $tiposAsociados = AssociateType::all();

        // 🔥 ✅ Obtener tipos de documentos para el filtro
        $tiposDocumentos = DocumentType::all(); // 👈 Agregamos esta línea

        return view('entities_section.entity_types.associated_trading_types.index', compact('asociadosTipos', 'tiposAsociados', 'selectedAsociadoTipo','tiposDocumentos'));
    }
}
