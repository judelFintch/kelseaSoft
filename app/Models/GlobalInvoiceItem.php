<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditable;
use App\Models\InvoiceItem;

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

    public function getRefCodeAttribute(): string
    {
        $firstId = $this->original_item_ids[0] ?? null;
        if (!$firstId) {
            return '---';
        }

        $invoiceItem = InvoiceItem::with(['tax', 'agencyFee', 'extraFee'])->find($firstId);
        if (!$invoiceItem) {
            return '---';
        }

        return match ($this->category) {
            'import_tax' => $invoiceItem->tax?->code ?? '---',
            'agency_fee' => $invoiceItem->agencyFee?->code ?? '---',
            'extra_fee' => $invoiceItem->extraFee?->code ?? '---',
            default => '---',
        };
    }
}
