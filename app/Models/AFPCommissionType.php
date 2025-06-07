<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AFPCommissionType extends Model
{
    use HasFactory;

    protected $table = 'tipo_comision_afp';
    protected $fillable = ['code', 'nombre'];

    // Relación con Empleados (Un tipo de comisión AFP puede estar asignado a varios empleados)
    public function empleados()
    {
        return $this->hasMany(Employee::class, 'tipo_comision_afp_id');
    }
}
