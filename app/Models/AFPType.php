<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AFPType extends Model
{
    use HasFactory;

    protected $table = 'tipo_afp';
    protected $fillable = ['code', 'nombre'];

    // Relación con Empleados (Un tipo de AFP puede estar asignado a varios empleados)
    public function empleados()
    {
        return $this->hasMany(Employee::class, 'tipo_afp_id');
    }
}
