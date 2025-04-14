<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Folder extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'folder_number',
        'truck_number',
        'trailer_number',
        'transporter',
        'driver_name',
        'driver_phone',
        'driver_nationality',
        'origin',
        'destination',
        'supplier',
        'client',
        'customs_office',
        'declaration_number',
        'declaration_type',
        'declarant',
        'customs_agent',
        'container_number',
        'weight',
        'fob_amount',
        'insurance_amount',
        'cif_amount',
        'arrival_border_date',
        'description',
    ];

    protected $casts = [
        'weight' => 'float',
        'fob_amount' => 'float',
        'insurance_amount' => 'float',
        'cif_amount' => 'float',
        'arrival_border_date' => 'date',
    ];

    public function files()
    {
        return $this->hasMany(FolderFile::class);
    }
}
