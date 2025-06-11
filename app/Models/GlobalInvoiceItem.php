<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditable;

class GlobalInvoiceItem extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'global_invoice_id',
        'category',
        'description',
        'quantity',
        'unit_price',
        'total_price',
        'original_item_ids',
    ];

    protected $casts = [
        'original_item_ids' => 'array',
        'category' => 'string',
    ];

    /**
     * Get the global invoice that owns the item.
     */
    public function globalInvoice(): BelongsTo
    {
        return $this->belongsTo(GlobalInvoice::class);
    }
}
