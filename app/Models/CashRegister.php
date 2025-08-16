<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRegister extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'balance',
        'currency_id',
    ];

    public function transactions()
    {
        return $this->hasMany(FolderTransaction::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
