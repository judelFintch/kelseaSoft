<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraFee extends Model
{
    //
    protected $fillable = [
        'code',
        'label',
        'description',
    ];
}
