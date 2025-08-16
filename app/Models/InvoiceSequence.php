<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSequence extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'type',
        'current_number',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
