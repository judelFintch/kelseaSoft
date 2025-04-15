<?php

namespace App\Models;

use App\Enums\DossierType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Folder extends Model
{
    use HasFactory, SoftDeletes;

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
        'fob_amount',
        'insurance_amount',
        'cif_amount',
        'arrival_border_date',
        'description',
        'dossier_type',
        'license_code',
        'bivac_code',
    ];

    protected $casts = [
        'arrival_border_date' => 'date',
        'weight' => 'float',
        'fob_amount' => 'float',
        'insurance_amount' => 'float',
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



}
