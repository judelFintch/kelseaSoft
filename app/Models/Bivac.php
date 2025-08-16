<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Bivac extends Model
{
    use Auditable;

    protected $fillable = [
        'code',
        'label',
        'description',
    ];
}
