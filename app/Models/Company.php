<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Company extends Model
{
    //
    use HasFactory, Auditable;

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
        'acronym',
    ];

    public function scopeNotDeleted(Builder $query)
    {
        return $query->where('is_deleted', false);
    }
}
