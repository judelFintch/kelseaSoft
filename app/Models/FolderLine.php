<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FolderLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'folder_id',
        'position_code',
        'description',
        'invoice_number',
        'colis',
        'emballage',
        'gross_weight',
        'net_weight',
        'fob_amount',
        'license_code',
        'fxi',
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
}
