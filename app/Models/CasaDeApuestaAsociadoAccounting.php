<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasaDeApuestaAsociadoAccounting extends Model
{
    use HasFactory;

    protected $table = 'casa_de_apuesta_asociado_accounting';

    protected $fillable = [
        'casa_de_apuesta_id',
        'asociado_tipo_asociado_id',
        'accounting_account_id',
    ];

    // Relación con CasaDeApuestaMoneda (muchos a uno)
    public function bettingHouseCurrency()
    {
        return $this->belongsTo(BettingHouseCurrency::class, 'casa_de_apuesta_id');
    }

    // Relación con AssociateTypeAssociate (muchos a uno)
    public function associateTypeAssociate()
    {
        return $this->belongsTo(AssociateTypeAssociate::class, 'asociado_tipo_asociado_id');
    }

    // Relación con AccountingAccount (muchos a uno)
    public function accountingAccount()
    {
        return $this->belongsTo(AccountingAccount::class, 'accounting_account_id');
    }
}
