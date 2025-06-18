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
        return $this->belongsTo(User::class);
    }

    /**
     * Retrieve a human-friendly identifier for the audited model.
     */
    public function getIdentifierAttribute(): string
    {
        $data = $this->new_data ?: $this->previous_data ?: [];

        foreach (['folder_number', 'invoice_number', 'operation_code', 'name', 'label', 'title'] as $field) {
            if (isset($data[$field]) && $data[$field] !== '') {
                return (string) $data[$field];
            }
        }

        return (string) $this->auditable_id;
    }
}
