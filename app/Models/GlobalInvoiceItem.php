<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GlobalInvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'global_invoice_id',
        'description',
        'quantity',
        'unit_price',
        'total_price',
        'original_item_ids',
    ];

    /**
     * Get the global invoice that owns the item.
     */
    public function globalInvoice(): BelongsTo
    {
        return $this->belongsTo(GlobalInvoice::class);
    }
}
