<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'label',
        'category',
        'amount_usd',
        'currency',
        'tax_id',
        'agency_fee_id',
        'extra_fee_id',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function agencyFee()
    {
        return $this->belongsTo(AgencyFee::class);
    }

    public function extraFee()
    {
        return $this->belongsTo(ExtraFee::class);
    }
}
