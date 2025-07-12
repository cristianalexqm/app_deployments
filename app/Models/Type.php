<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $table = 'tipos';
    protected $fillable = ['nombre'];
    
    // Relación con TipoEntidad (Un tipo puede estar en muchas entidades)
    public function tipoEntidades()
    {
        return $this->hasMany(EntityType::class, 'tipo_id');
    }
}
