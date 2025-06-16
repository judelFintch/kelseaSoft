<?php

namespace App\Observers;

use App\Models\DocumentType;
use App\Services\Folder\FolderFieldService;

class DocumentTypeObserver
{
    /**
     * Handle the DocumentType "saved" event.
     */
    public function saved(DocumentType $documentType): void
    {
        if ($documentType->folder_field) {
            FolderFieldService::ensureFieldExists($documentType->folder_field);
        }
    }
}
