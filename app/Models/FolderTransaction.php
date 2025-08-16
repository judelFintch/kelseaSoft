<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FolderTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'folder_id',
        'cash_register_id',
        'user_id',
        'type',
        'amount',
        'currency_id',
        'label',
        'transaction_date',
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function cashRegister()
    {
        return $this->belongsTo(CashRegister::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
