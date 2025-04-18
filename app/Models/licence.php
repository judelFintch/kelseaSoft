<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Licence extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'license_number',
        'license_type',
        'license_category',
        'currency',
        'max_folders',
        'remaining_folders',
        'initial_weight',
        'remaining_weight',
        'initial_fob_amount',
        'remaining_fob_amount',
        'quantity_total',
        'remaining_quantity',
        'freight_amount',
        'insurance_amount',
        'other_fees',
        'cif_amount',
        'payment_mode',
        'payment_beneficiary',
        'transport_mode',
        'transport_reference',
        'invoice_date',
        'validation_date',
        'expiry_date',
        'customs_regime',
        'customs_office_id',
        'supplier_id',
        'company_id',
        'notes',
    ];

    protected $casts = [
        'initial_weight' => 'float',
        'remaining_weight' => 'float',
        'initial_fob_amount' => 'float',
        'remaining_fob_amount' => 'float',
        'quantity_total' => 'float',
        'remaining_quantity' => 'float',
        'freight_amount' => 'float',
        'insurance_amount' => 'float',
        'other_fees' => 'float',
        'cif_amount' => 'float',
        'invoice_date' => 'date',
        'validation_date' => 'date',
        'expiry_date' => 'date',
    ];

    // 🔗 Relations
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function customsOffice()
    {
        return $this->belongsTo(CustomsOffice::class);
    }

    public function folders()
    {
        return $this->hasMany(Folder::class);
    }
}
