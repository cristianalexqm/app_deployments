<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardType extends Model
{
    use HasFactory;

    protected $table = 'tipos_tarjetas';

    protected $fillable = ['cod', 'emisor', 'estado'];

    public $timestamps = true;
}
