<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'amount',
        'pay_date',
        'status',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
