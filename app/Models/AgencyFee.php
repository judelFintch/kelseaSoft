<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgencyFee extends Model
{
    protected $fillable = [
        'code',
        'label',
        'description',
    ];
}
