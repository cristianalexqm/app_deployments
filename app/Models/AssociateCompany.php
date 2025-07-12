<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociateCompany extends Model
{
    use HasFactory;

    protected $table = 'associate_companies';

    protected $fillable = [
        'associated_id',
        'own_company_id',
        'estado'
    ];

    public function associated()
    {
        return $this->belongsTo(Associate::class, 'associated_id');
    }

    public function ownCompany()
    {
        return $this->belongsTo(OwnCompany::class, 'own_company_id');
    }

    // public function status()
    // {
    //     return $this->belongsTo(StatusAssignmentAssociatedCompany::class, 'estado');
    // }

    public function companyAssociateAccountings()
    {
        return $this->hasMany(CompanyAssociateAccounting::class, 'associate_company_id');
    }

    public function getEstadoTextoAttribute()
    {
        return $this->estado ? 'Activo' : 'Inactivo';
    }
}
