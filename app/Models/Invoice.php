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
        'global_invoice_id',
        'status',
        'folder_id', // Ajout de folder_id
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

    /**
     * Get the global invoice that owns the invoice.
     */
    public function globalInvoice()
    {
        return $this->belongsTo(GlobalInvoice::class);
    }

    /**
     * Get the folder that owns the invoice.
     */
    public function folder()
    {
        return $this->belongsTo(\App\Models\Folder::class);
    }
}
