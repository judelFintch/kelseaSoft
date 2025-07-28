<?php

namespace App\Models;

use App\Enums\DossierType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Kyslik\ColumnSortable\Sortable;
use App\Models\FolderLine;

class Folder extends Model
{
    use HasFactory, SoftDeletes;
    use Sortable;
    

    protected $fillable = [
        'folder_number',
        'truck_number',
        'trailer_number',
        'invoice_number',
        'transporter_id',
        'driver_name',
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
        'cif_amount',
        'arrival_border_date',
        'description',
        'dossier_type',
        'license_code',
        'bivac_code',
        'license_id',
        'company_id',
        'scelle_number',
        'manifest_number',
        'incoterm',
        'customs_regime',
        'additional_code',
        'quotation_date',
        'opening_date',
        'entry_point',

    ];

    protected $casts = [
        'arrival_border_date' => 'date',
        'weight' => 'float',
        'quantity' => 'float',
        'fob_amount' => 'float',
        'insurance_amount' => 'float',
        'cif_amount' => 'float',
        'dossier_type' => DossierType::class,
        'quotation_date' => 'date',
        'opening_date' => 'date',
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

    public function license()
    {
        return $this->belongsTo(Licence::class);
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

    public function lines()
    {
        return $this->hasMany(FolderLine::class);
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
