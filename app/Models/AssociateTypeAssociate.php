<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociateTypeAssociate extends Model
{
    use HasFactory;

    protected $table = 'asociado_tipo_asociado';
    protected $fillable = [
        'asociado_id',
        'tipo_asociado_id',
        'code_tipo',
        'code_sistema',
        'estado',
        'fecha_alta',
        'fecha_baja'
    ];

    // Relación con Associate (Cada registro pertenece a un asociado)
    public function asociado()
    {
        return $this->belongsTo(Associate::class, 'asociado_id');
    }

    // Relación con AssociateType (Cada registro pertenece a un tipo de asociado)
    public function tipoAsociado()
    {
        return $this->belongsTo(AssociateType::class, 'tipo_asociado_id');
    }
    
    public function empresas()
    {
        return $this->hasMany(AssociateTypeAssociateCompany::class, 'associate_type_associate_id');
    }

    // public function companyAssociateAccounting()
    // {
    //     return $this->hasMany(CompanyAssociateAccounting::class, 'associate_type_associate_id');
    // }

    // public function associateTypeAssociateCompanies()
    // {
    //     return $this->hasMany(AssociateTypeAssociateCompany::class, 'associate_type_associate_id');
    // }
}
