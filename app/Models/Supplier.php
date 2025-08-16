<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Supplier extends Model
{
    use Auditable;

    protected $fillable = ['name', 'phone', 'email', 'country'];

    /**
     * Relationship: A Supplier may have many folders (optional).
     */
    public function folders()
    {
        return $this->hasMany(\App\Models\Folder::class);
    }
}
