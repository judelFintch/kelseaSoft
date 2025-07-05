<?php

namespace App\Models;

use App\Enums\DossierType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Currency;
use App\Models\DocumentType;
use App\Models\FolderTransaction;
use App\Traits\Auditable;
use Kyslik\ColumnSortable\Sortable;

class Folder extends Model
{
    use HasFactory, SoftDeletes, Auditable;
    use Sortable;
    

    protected $fillable = [
        'folder_number',
        'truck_number',
        'trailer_number',
        'invoice_number',
        'goods_type',
        'transporter_id',
        'driver_name',
        'order_number',
        'driver_phone',
        'driver_nationality',
        'origin_id',
        'destination_id',
        'supplier_id',
        'client',
        'customs_office_id',
        'declaration_number',
        'declaration_type_id',
        'declarant',
        'customs_agent',
        'container_number',
        'weight',
        'quantity',
        'fob_amount',
        'insurance_amount',
        'freight_amount',
        'cif_amount',
        'currency_id',
        'arrival_border_date',
        'description',
        'dossier_type',
        'license_code',
        'bivac_code',
        'license_id',
        'company_id',
        
    ];

    protected $casts = [
        'arrival_border_date' => 'date',
        'weight' => 'float',
        'quantity' => 'float',
        'fob_amount' => 'float',
        'insurance_amount' => 'float',
        'freight_amount' => 'float',
        'cif_amount' => 'float',
        'dossier_type' => DossierType::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function transporter()
    {
        return $this->belongsTo(Transporter::class);
    }

    public function origin()
    {
        return $this->belongsTo(Location::class, 'origin_id');
    }

    public function destination()
    {
        return $this->belongsTo(Location::class, 'destination_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function customsOffice()
    {
        return $this->belongsTo(CustomsOffice::class);
    }

    public function declarationType()
    {
        return $this->belongsTo(DeclarationType::class);
    }

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class);
    }

    public function files()
    {
        return $this->hasMany(\App\Models\FolderFile::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function license()
    {
        return $this->belongsTo(Licence::class);
    }

    /**
     * Calculate overall progress percentage for the folder.
     */
    public function progressPercentage(): Attribute
    {
        return Attribute::get(function (): int {
            $totalTasks = DocumentType::count() + 1; // include invoice as a task

            if ($totalTasks === 0) {
                return 0;
            }

            // count how many distinct document types have files uploaded
            $completedDocs = $this->files()
                ->distinct('document_type_id')
                ->count('document_type_id');

            // invoice considered completed when present
            $invoiceCompleted = $this->invoice ? 1 : 0;

            $completed = $completedDocs + $invoiceCompleted;

            return (int) round(($completed / $totalTasks) * 100);
        });
    }

    public function licenseLogs()
    {
        return $this->hasMany(FoldeLicence::class);
    }

    /**
     * Get the invoice associated with the folder.
     */
    public function invoice()
    {
        return $this->hasOne(\App\Models\Invoice::class);
    }

    /**
     * Get all accounting transactions related to the folder.
     */
    public function transactions()
    {
        return $this->hasMany(FolderTransaction::class);
    }

    /**
     * Compute the balance of all transactions for the folder.
     */
    public function balance(): Attribute
    {
        return Attribute::get(function (): float {
            $income = $this->transactions()->where('type', 'income')->sum('amount');
            $expense = $this->transactions()->where('type', 'expense')->sum('amount');
            return $income - $expense;
        });
    }

    public $sortable = [
        'id', 'folder_number', 'truck_number', 'trailer_number',
        'invoice_number', 'goods_type', 'agency', 'pre_alert_place',
        'transport_mode', 'internal_reference', 'order_number',
        'folder_date', 'driver_name', 'driver_phone', 'driver_nationality',
        'declaration_number', 'declarant', 'customs_agent', 'container_number',
        'arrival_border_date', 'tr8_number', 'tr8_date', 't1_number',
        't1_date', 'formalities_office_reference', 'im4_number',
        'im4_date', 'liquidation_number', 'liquidation_date',
        'quitance_number', 'quitance_date', 'dossier_type',
        'license_code', 'bivac_code', 'description', 'created_at'
    ];
}
