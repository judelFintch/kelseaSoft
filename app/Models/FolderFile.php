<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FolderFile extends Model
{
    //
    protected $fillable = [
        'folder_id',
        'name',
        'path',
        'document_type_id',
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }
}
