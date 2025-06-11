<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Currency extends Model
{
    /** @use HasFactory<\Database\Factories\CurrencyFactory> */
    use HasFactory, Auditable;
    

    protected $fillable = [
        'code',
        'name',
        'symbol',
        'is_default',
        'exchange_rate',
    ];

    public function invoices()
    {
        return $this->hasMany(\App\Models\Invoice::class);
    }
}
