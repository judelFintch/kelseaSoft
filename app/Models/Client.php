<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'company_name',
        'contact_person',
        'email',
        'phone',
        'secondary_phone',
        'address',
        'city',
        'state',
        'country',
        'tax_id',
        'registration_number',
        'identification_number',
        'rccm',
        'website',
        'notes'
    ];

    public function dossiers()
    {
        return $this->hasMany(Dossier::class);
    }
}
