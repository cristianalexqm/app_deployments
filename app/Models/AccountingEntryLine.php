<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingEntryLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_entry_id',
        'accounting_account_id',
        'debit',
        'credit'
    ];

    public function accountingEntry()
    {
        return $this->belongsTo(AccountingEntry::class);
    }

    public function accountingAccount()
    {
        return $this->belongsTo(AccountingAccount::class);
    }
}
