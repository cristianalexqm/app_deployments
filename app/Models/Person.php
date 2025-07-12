<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'personas';
    protected $fillable = [
        'nombre_pila',
        'apellido_paterno',
        'apellido_materno',
        'ruc',
        'fecha_nacimiento',
        'correo',
        'genero',
        'telefono',
        'codigo_postal',
        'entidad_id'
    ];
    
    // Relación con Entidad (Cada persona pertenece a una entidad)
    public function entidad()
    {
        return $this->belongsTo(Entity::class, 'entidad_id');
    }
}
