<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = ['cuenta', 'nivel', 'tipo', 'trading', 'contabilidad', 'cuentas_amarre'];
}
