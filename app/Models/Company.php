<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
USE Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'business_category',
        'tax_id',
        'code',
        'national_identification',
        'commercial_register',
        'import_export_number',
        'nbc_number',
        'phone_number',
        'email',
        'physical_address'
    ];
}
