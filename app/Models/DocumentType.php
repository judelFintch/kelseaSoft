<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class DocumentType extends Model
{
    use Auditable;

    //
    protected $fillable = ['name'];

    public function files()
    {
        return $this->hasMany(FolderFile::class);
    }
}
