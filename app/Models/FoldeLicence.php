<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoldeLicence extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $table = 'folde_licences';

    protected $fillable = [
        'folder_id',
        'licence_id',
        'fob_used',
        'weight_used',
        'quantity_used',
    ];

    /**
     * 📁 Relation avec le dossier.
     */
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    /**
     * 🧾 Relation avec la licence.
     */
    public function licence()
{
    return $this->belongsTo(\App\Models\Licence::class, 'licence_id');
}
    
}
