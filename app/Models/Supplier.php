<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'country'];
    
    /**
     * Relationship: A Supplier may have many folders (optional).
     */
    public function folders()
    {
        return $this->hasMany(\App\Models\Folder::class);
    }
}

