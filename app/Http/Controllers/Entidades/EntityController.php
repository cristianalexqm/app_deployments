<?php

namespace App\Http\Controllers\Entidades;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entity;
use App\Models\Person;
use App\Models\Company;
use App\Models\DocumentType;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EntityController extends Controller
{
    //Muestra el listado de entidades, con dos botones
    public function index(Request $request)
    {
        $entities = Entity::with([
            'persona',
            'empresa',
            'tipoDocumento:id,code',
            'tiposEntidades:id,tipo_id,entidad_id,estado',
            'tiposEntidades.tipo:id,nombre'
        ])->get();
        return Inertia::render('entities_section/entities/index', compact('entities'));
    }

    //Muestra el formulario de creación, diferenciando si es 'persona' o 'empresa' según la query string "tipo".
    public function create(Request $request)
    {
        // Determina si el usuario desea crear una persona o una empresa
        $tipo = $request->query('tipo', 'persona');
        // Carga los tipos de documento para un select (si lo necesitas en la vista)
        $tipoDocumentos = DocumentType::all();

        return Inertia::render('entities_section/entities/create', compact('tipo', 'tipoDocumentos'));
    }

    //Guarda la nueva entidad en la BD, junto con la info adicional de persona o empresa.
    public function store(Request $request)
    {
        //dd($request->toArray());
        $request->validate([
            'tipo_documento_id' => 'required|exists:tipo_documentos,id',
            'documento' => 'required|unique:entidades,documento|max:20',
            'nombre_razon_social' => 'required|max:255',
            'direccion' => 'required|max:255',
            'pais' => 'required|max:100',
            'departamento' => 'nullable|max:100',
            'provincia' => 'nullable|max:100',
            'distrito' => 'nullable|max:100',
            'descripcion' => 'nullable|max:1000',
            'foto_usuario' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Para imágenes
            'tipo' => 'required|in:persona,empresa'
        ]);

        if ($request->tipo === 'persona') {
            $request->validate([
                'nombre_pila' => 'required|max:100',
                'apellido_paterno' => 'required|max:100',
                'apellido_materno' => 'required|max:100',
                'ruc' => 'required|max:11|unique:personas,ruc',
                'fecha_nacimiento' => 'required|date',
                'correo' => 'required|email|max:255',
                'genero' => 'nullable|in:masculino,femenino,otro',
                'telefono' => 'nullable|max:20',
                'codigo_postal' => 'nullable|max:20',
            ]);
        } elseif ($request->tipo === 'empresa') {
            $request->validate([
                'persona_contacto' => 'required|max:255',
                'celular_contacto' => 'required|max:20',
                'correo_contacto' => 'required|email|max:255',
                'tipo_empresa' => 'required|in:natural,juridica',
            ]);
        }

        $fotoPath = null;
        if ($request->hasFile('foto_usuario')) {
            $fotoPath = $request->file('foto_usuario')->store('fotos', 'public'); // Guarda en storage/app/public/fotos/
        }

        // Crear la entidad con los campos actualizados
        $entity = Entity::create($request->only([
            'tipo_documento_id',
            'documento',
            'nombre_razon_social',
            'direccion',
            'pais',
            'departamento',
            'provincia',
            'distrito',
            'descripcion',
            'foto_usuario' => $fotoPath, // Guardar la imagen si existe
        ]));

        if ($request->tipo === 'persona') {
            Person::create([
                'entidad_id' => $entity->id,
                'nombre_pila' => $request->nombre_pila,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'ruc' => $request->ruc,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'correo' => $request->correo,
                'genero' => $request->genero,
                'telefono' => $request->telefono,
                'codigo_postal' => $request->codigo_postal,
            ]);
        } else {
            Company::create([
                'entidad_id' => $entity->id,
                'persona_contacto' => $request->persona_contacto,
                'celular_contacto' => $request->celular_contacto,
                'correo_contacto' => $request->correo_contacto,
                'tipo_empresa' => $request->tipo_empresa,
            ]);
        }
        // ✅ 🔥 Redirigir a la vista para asignar tipos con el ID recién creado
        //return redirect()->route('entities.types.index', $entity->id)->with('success', 'Entidad creada exitosamente. Ahora puedes asignar tipos.');
        return redirect()->route('entities.index')->with('success', 'Entidad creada exitosamente.');
    }

    //Muestra el formulario de edición para una entidad, detectando si es persona o empresa.
    public function edit(Entity $entity)
    {
        // Si la relación "persona" existe, es persona; si "empresa" existe, es empresa
        $entity->load(['persona', 'empresa']);
        $tipo = $entity->persona ? 'persona' : 'empresa';
        $tipoDocumentos = DocumentType::all();

        return Inertia::render('entities_section/entities/edit', compact('entity', 'tipo', 'tipoDocumentos'));
    }

    //Actualiza los datos de la entidad y, según el caso, también actualiza los datos de la persona o de la empresa.
    public function update(Request $request, Entity $entity)
    {
        // Validaciones generales
        $request->validate([
            'nombre_razon_social' => 'required|max:255',
            'direccion' => 'required|max:255',
            'pais' => 'required|max:100',
            'departamento' => 'nullable|max:100',
            'provincia' => 'nullable|max:100',
            'distrito' => 'nullable|max:100',
            'descripcion' => 'nullable|max:1000',
            'foto_usuario' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Para imágenes
        ]);

        // **1. Procesar la imagen si se ha subido una nueva**
        if ($request->hasFile('foto_usuario')) {
            // Eliminar la imagen anterior si existe
            if ($entity->foto_usuario) {
                Storage::disk('public')->delete($entity->foto_usuario);
            }

            // Guardar la nueva imagen
            $fotoPath = $request->file('foto_usuario')->store('fotos', 'public');
        } else {
            $fotoPath = $entity->foto_usuario; // Mantener la imagen actual si no se sube una nueva
        }

        // Actualizar la entidad
        $entity->update($request->only([
            'nombre_razon_social',
            'direccion',
            'pais',
            'departamento',
            'provincia',
            'distrito',
            'descripcion',
            'foto_usuario' => $fotoPath, // Nueva imagen o la existente
        ]));

        // Si es persona, actualizar datos en "person"
        if ($entity->persona) {
            $request->validate([
                'nombre_pila' => 'required|max:100',
                'apellido_paterno' => 'required|max:100',
                'apellido_materno' => 'required|max:100',
                'ruc' => 'required|max:11|unique:personas,ruc,' . $entity->persona->id,
                'fecha_nacimiento' => 'required|date',
                'correo' => 'required|email|max:255',
                'genero' => 'nullable|in:masculino,femenino,otro',
                'telefono' => 'nullable|max:20',
                'codigo_postal' => 'nullable|max:20',
            ]);

            $entity->persona->update($request->only([
                'nombre_pila',
                'apellido_paterno',
                'apellido_materno',
                'ruc',
                'fecha_nacimiento',
                'correo',
                'genero',
                'telefono',
                'codigo_postal',
            ]));
        }
        // Si es empresa, actualizar datos en "company"
        elseif ($entity->empresa) {
            $request->validate([
                'persona_contacto' => 'required|max:255',
                'celular_contacto' => 'required|max:20',
                'correo_contacto' => 'required|email|max:255',
                'tipo_empresa' => 'required|in:natural,juridica',
            ]);

            $entity->empresa->update($request->only([
                'persona_contacto',
                'celular_contacto',
                'correo_contacto',
                'tipo_empresa',
            ]));
        }

        return redirect()->route('entities.index')->with('success', 'Entidad actualizada correctamente.');
    }

    //Elimina la entidad y (por cascada) sus datos en persona o empresa (SIEMPRE Y CUANDO NO TENGA TIPOS ASOCIADOS).
    public function destroy(Entity $entity)
    {
        // ✅ Verificar si hay datos relacionados en entity_types
        $tieneTiposRelacionados = $entity->tiposEntidades()->exists();

        if ($tieneTiposRelacionados) {
            // ❌ Si hay datos relacionados, mostrar alerta y NO eliminar
            return redirect()->route('entities.index')
                ->with('error', 'No puedes eliminar esta entidad porque tiene datos asociados.');
        }

        // ✅ Si NO hay datos relacionados, proceder con la eliminación
        $entity->delete();

        return redirect()->route('entities.index')
            ->with('success', 'Entidad eliminada correctamente.');
    }
}
