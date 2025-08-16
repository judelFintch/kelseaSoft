<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class MerchandiseType extends Model
{
    use Auditable;

    //
    protected $fillable = [
        'name',
        'tariff_position',
    ];
}
