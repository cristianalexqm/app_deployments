<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAssociateAccounting extends Model
{
    use HasFactory;

    protected $table = 'company_associate_accounting';

    protected $fillable = [
        'accounting_account_id',
        'associate_company_id',
    ];

    public function accountingAccount()
    {
        return $this->belongsTo(AccountingAccount::class, 'accounting_account_id');
    }

    public function associateCompany()
    {
        return $this->belongsTo(AssociateCompany::class, 'associate_company_id');
    }
}
