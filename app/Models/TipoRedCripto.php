<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoRedCripto extends Model
{
    use HasFactory;

    protected $table = 'tipo_red_criptos';
    protected $fillable = ['cod', 'red', 'estado'];
    public $timestamps = true;

    public function cuentasCripto()
    {
        return $this->hasMany(CuentaCripto::class, 'tipo_red_cripto_id');
    }
}
