<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Auditable;

class InvoiceItem extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'invoice_id',
        'label',
        'category',
        'amount_usd',
        'currency_id',
        'exchange_rate',
        'amount_cdf',
        'tax_id',
        'agency_fee_id',
        'extra_fee_id',
    ];

    // 🔁 Relations

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

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
