<?php

namespace App\Models;
use App\Models\FolderFile;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    //
    protected $fillable = ['name'];

    public function files()
    {
        return $this->hasMany(FolderFile::class);
    }
}
