<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountTypeBanks extends Model
{
    use HasFactory;

    protected $table = 'tipos_cuentas_bancos';

    protected $fillable = ['cod', 'tipo_cuenta', 'estado'];

    public $timestamps = true;

    // Relación con TiposBanco (uno a muchos)
    public function tiposBancos()
    {
        return $this->hasMany(BankType::class, 'tipos_cuentas_bancos_id');
    }
}
