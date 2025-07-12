<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;

    protected $table = 'entidades';
    protected $fillable = [
        'tipo_documento_id',
        'documento',
        'nombre_razon_social',
        'direccion',
        'pais',
        'departamento',
        'provincia',
        'distrito',
        'descripcion',
        'foto_usuario'
    ];
    
    // Relación con TipoDocumento
    public function tipoDocumento()
    {
        return $this->belongsTo(DocumentType::class, 'tipo_documento_id');
    }

    // Relación con Persona
    public function persona()
    {
        return $this->hasOne(Person::class, 'entidad_id');
    }

    // Relación con Empresa
    public function empresa()
    {
        return $this->hasOne(Company::class, 'entidad_id');
    }

    // Relación con TipoEntidad (una entidad puede tener varios tipos)
    public function tiposEntidades()
    {
        return $this->hasMany(EntityType::class, 'entidad_id');
    }
}
