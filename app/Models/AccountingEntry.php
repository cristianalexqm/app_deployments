<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'description'
    ];

    public function entryLines()
    {
        return $this->hasMany(AccountingEntryLine::class);
    }
}
