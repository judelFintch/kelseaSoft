<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;
use App\Models\Bivac;
use App\Models\LicenceFile;

/**
 * App\Models\Licence
 *
 * @property int $id
 * @property string $license_number
 * @property string $license_type
 * @property string|null $license_category
 * @property string $currency
 * @property int $max_folders
 * @property int $remaining_folders
 * @property float $initial_weight
 * @property float $remaining_weight
 * @property float $initial_fob_amount
 * @property float $remaining_fob_amount
 * @property float $quantity_total
 * @property float $remaining_quantity
 * @property float|null $freight_amount
 * @property float|null $insurance_amount
 * @property float|null $other_fees
 * @property float|null $cif_amount
 * @property string|null $payment_mode
 * @property string|null $payment_beneficiary
 * @property string|null $transport_mode
 * @property string|null $transport_reference
 * @property \Illuminate\Support\Carbon|null $invoice_date
 * @property \Illuminate\Support\Carbon|null $validation_date
 * @property \Illuminate\Support\Carbon|null $expiry_date
 * @property string|null $customs_regime
 * @property int|null $customs_office_id
 * @property int|null $supplier_id
 * @property int|null $company_id
 * @property string|null $notes
 */

class Licence extends Model
{
    use SoftDeletes, Auditable;

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
        'bivac_id',
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

    // Entreprise propriétaire de la licence
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Fournisseur lié à la licence
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Bureau de douane
    public function customsOffice()
    {
        return $this->belongsTo(CustomsOffice::class);
    }

    // Dossiers rattachés à cette licence
    public function folders()
    {
        return $this->hasMany(Folder::class);
    }

    // BIVAC lié à la licence
    public function bivac()
    {
        return $this->belongsTo(Bivac::class);
    }

    // Fichiers BIVAC associés
    public function files()
    {
        return $this->hasMany(LicenceFile::class);
    }
}
