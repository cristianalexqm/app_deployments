<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusAssignmentAssociatedCompany extends Model
{
    use HasFactory;

    protected $table = 'status_assignment_associated_companies';

    protected $fillable = [
        'name',
        'description'
    ];

    // ✅ Relación inversa con AssociateTypeAssociateCompany
    public function associateTypeAssociateCompanies()
    {
        return $this->hasMany(AssociateTypeAssociateCompany::class, 'estado');
    }
}
