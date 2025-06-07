<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileOperator extends Model
{
    use HasFactory;

    protected $table = 'operadores_moviles';

    protected $fillable = ['cod', 'operador', 'estado'];

    public $timestamps = true;
}
