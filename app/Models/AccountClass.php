<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountClass extends Model
{
    use HasFactory;

    protected $table = 'clases_cuentas';

    protected $fillable = ['cod', 'tipo_clase_cuenta', 'estado'];

    public $timestamps = true;
}
