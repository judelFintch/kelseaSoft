<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GlobalInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'global_invoice_number',
        'company_id',
        'issue_date',
        'due_date',
        'total_amount',
        'notes',
    ];

    /**
     * Get the company that owns the global invoice.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the invoices for the global invoice.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the items for the global invoice.
     */
    public function globalInvoiceItems(): HasMany
    {
        return $this->hasMany(GlobalInvoiceItem::class);
    }
}
