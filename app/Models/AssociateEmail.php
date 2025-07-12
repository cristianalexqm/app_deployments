<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociateEmail extends Model
{
    use HasFactory;

    protected $table = 'correos_asociados';
    protected $fillable = [
        'correo',
        'password',
        'asociado_id'
    ];

    // Relación belongsTo porque cada correo pertenece a un asociado
    public function asociado()
    {
        return $this->belongsTo(Associate::class, 'asociado_id');
    }
}
