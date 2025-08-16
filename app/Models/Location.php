<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Location extends Model
{
    use Auditable;

    //
    protected $fillable = ['name'];
}
