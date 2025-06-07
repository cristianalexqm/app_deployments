<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankType extends Model
{
    use HasFactory;

    protected $table = 'tipos_bancos';

    protected $fillable = ['cod', 'tipo_banco', 'tipo_recurso', 'tipos_cuentas_bancos_id', 'estado'];

    public $timestamps = true;

    /* // Relación con Empleados (Un banco puede estar asignado a varios empleados para sueldos)
    public function empleados()
    {
        return $this->hasMany(Employee::class, 'tipo_banco_sueldo');
    }

    // Relación con Clientes (Un banco puede estar asignado a varios clientes)
    public function clientes()
    {
        return $this->hasMany(Client::class, 'tipo_banco_id');
    }

    // Relación con Proveedores (Un banco puede estar asignado a varios proveedores)
    public function proveedores()
    {
        return $this->hasMany(Provider::class, 'tipo_banco_id');
    } */

    // Relación con TiposCuentasBanco (muchos a uno)
    public function tipoCuentaBanco()
    {
        return $this->belongsTo(AccountTypeBanks::class, 'tipos_cuentas_bancos_id');
    }

    /* // Relación con BancoAcceso (Un banco acceso puede tener varios bancos)
    public function bancosAcceso()
    {
        return $this->hasMany(BancoAcceso::class, 'tipo_banco_id');
    } */
}
