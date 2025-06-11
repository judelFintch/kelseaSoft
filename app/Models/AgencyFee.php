<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgencyFee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'label',
        'description',
    ];
}
