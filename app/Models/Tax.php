<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Auditable;

class Tax extends Model
{
    use HasFactory, Auditable;
    
    protected $fillable = [
        'code',
        'label',
        'default_amount',
        'currency_id',
        'exchange_rate',
        'default_converted_amount',
        'description',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
