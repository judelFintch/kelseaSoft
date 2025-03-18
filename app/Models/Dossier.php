<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dossier extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'client_id',
        'supplier',
        'goods_type',
        'description',
        'quantity',
        'total_weight',
        'declared_value',
        'fob',
        'insurance',
        'currency',
        'manifest_number',
        'container_number',
        'vehicle_plate',
        'contract_type',
        'delivery_place',
        'file_type',
        'expected_arrival_date',
        'border_arrival_date',
        'invoice_number',
        'invoice_date',
        'status',
        'file_number'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
