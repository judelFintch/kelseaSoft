<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['dossier_id', 'name', 'path', 'type', 'size'];

    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }
}
