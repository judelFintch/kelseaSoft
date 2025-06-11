<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Transporter extends Model
{
    use Auditable;

    //
    protected $fillable = ['name', 'phone', 'email', 'country'];
}
