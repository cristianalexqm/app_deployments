<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $table = 'monedas';

    protected $fillable = ['cod', 'moneda', 'naturaleza', 'estado'];

    public $timestamps = true;

    /* // Relación con Empleados (Una moneda puede estar asociada a varios empleados)
    public function empleados()
    {
        return $this->hasMany(Employee::class, 'moneda_id');
    }

    // Relación con CasaDeApuestaMoneda (uno a muchos)
    public function casasDeApuestaMoneda()
    {
        return $this->hasMany(BettingHouseCurrency::class, 'moneda_id');
    }

    public function accountingAccounts()
    {
        return $this->hasMany(AccountingAccount::class, 'currency_id');
    } */
}
