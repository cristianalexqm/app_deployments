<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociateTypeAssociateCompany extends Model
{
    use HasFactory;

    protected $table = 'associate_type_associate_companies';

    protected $fillable = [
        'associate_type_associate_id',
        'own_company_id',
        'estado',
    ];

    public function associateTypeAssociate()
    {
        return $this->belongsTo(AssociateTypeAssociate::class, 'associate_type_associate_id');
    }

    public function ownCompany()
    {
        return $this->belongsTo(OwnCompany::class, 'own_company_id');
    }

    // public function companyAssociateAccountings()
    // {
    //     return $this->hasMany(CompanyAssociateAccounting::class, 'associate_type_associate_company_id');
    // }

    public function getEstadoTextoAttribute()
    {
        return $this->estado ? 'Activo' : 'Inactivo';
    }
}
