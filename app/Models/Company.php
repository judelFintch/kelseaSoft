<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

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
        'physical_address',
        'is_deleted',
    ];


    public function scopeNotDeleted(Builder $query)
    {
        return $query->where('is_deleted', false);
    }
}
