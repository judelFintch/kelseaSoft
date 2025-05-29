<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'company_id',
        'operation_code',
        'product',
        'weight',
        'fob_amount',
        'insurance_amount',
        'freight_amount',
        'cif_amount',
        'invoice_date',
        'payment_mode',
        'total_usd',
    ];

    protected $casts = [
        'invoice_date' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
