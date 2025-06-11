<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id', 'auditable_id', 'auditable_type', 'operation', 'previous_data', 'new_data', 'message',
    ];

    protected $casts = [
        'previous_data' => 'array',
        'new_data' => 'array',
    ];

    public function user()
    {
        return \$this->belongsTo(User::class);
    }
}
