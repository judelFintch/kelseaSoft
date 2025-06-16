<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * This application historically used the French table name
     * "entreprises". Explicitly defining the table avoids issues when
     * Laravel tries to infer the English pluralised form "enterprises".
     */
    protected $table = 'entreprises';

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
