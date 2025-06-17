<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class LicenceFile extends Model
{
    use Auditable;

    protected $fillable = [
        'licence_id',
        'name',
        'path',
    ];

    public function licence()
    {
        return $this->belongsTo(Licence::class);
    }
}
