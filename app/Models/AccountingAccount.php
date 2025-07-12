<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'sports_trading',
        'accounting_type',
        'currency_id',
        'level',
        'is_base',
        'category_id',
        'parent_id',
        'own_company_id',
        'debit_linked_account',
        'credit_linked_account',
    ];


    // obtener el padre de una cuenta contable 
    public function parent()
    {
        return $this->belongsTo(AccountingAccount::class, 'parent_id')->withDefault();
    }

    public function scopeParents($query, $categoryId = null)
    {
        return $query->whereNull('parent_id')
            ->select(['id', 'code', 'name', 'level', 'category_id'])
            ->with(['category:id,name'])
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->orderBy('code');
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    public function children()
    {
        return $this->hasMany(AccountingAccount::class, 'parent_id')
            ->select(['id', 'code', 'name', 'level', 'category_id', 'sports_trading'])
            ->with(['category:id,name']);
        // ->orderBy('code');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function ownCompany()
    {
        return $this->belongsTo(OwnCompany::class, 'own_company_id');
    }

    public function ancestors()
    {
        return $this->parent()
            ->select(['id', 'code', 'name', 'parent_id'])
            ->with('ancestors');
    }

    public function descendants()
    {
        return $this->children()
            ->select(['id', 'code', 'name', 'parent_id'])
            ->with('descendants');
    }

    // -------------------------------------------------------------------------------------------------
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    // public function companyAssociate()
    // {
    //     return $this->hasOne(CompanyAssociateAccounting::class, 'accounting_account_id');
    // }
    
    public function companyAssociateAccountings()
    {
        return $this->hasMany(CompanyAssociateAccounting::class, 'accounting_account_id');
    }
}
