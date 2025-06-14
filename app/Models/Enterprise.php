<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tagline',
        'tax_id',
        'commercial_register',
        'national_identification',
        'agreement_number',
        'phone_number',
        'email',
        'physical_address',
        'footer_note',
        'logo',
    ];
}
