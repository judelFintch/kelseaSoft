<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id', 'auditable_id', 'auditable_type', 'operation', 'previous_data', 'new_data', 'message',
    ];

    protected $casts = [
        'previous_data' => 'array',
        'new_data' => 'array',
    ];
}
