<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerType extends Model
{
    use HasFactory;

    protected $table = 'tipo_trabajador';
    protected $fillable = ['code', 'nombre'];

    // Relación con Empleados (Un tipo de trabajador puede tener varios empleados)
    public function empleados()
    {
        return $this->hasMany(Employee::class, 'tipo_trabajador_id');
    }
}
