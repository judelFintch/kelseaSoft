<?php

namespace App\Observers;

use App\Models\Folder;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class DocumentObserver
{
    /**
     * Enregistre l'audit lors de la création.
     */
    public function created(Folder $document)
    {
        AuditLog::create([
            'user_id'       => Auth::id(),
            'auditable_id'  => $document->id,
            'auditable_type'=> get_class($document),
            'operation'     => 'CREATE',
            'previous_data' => null,
            'new_data'      => $document->toArray(),
            'message'       => 'Document created'
        ]);
    }

    /**
     * Enregistre l'audit lors de la mise à jour.
     */
    public function updated(Folder $document)
    {
        AuditLog::create([
            'user_id'       => Auth::id(),
            'auditable_id'  => $document->id,
            'auditable_type'=> get_class($document),
            'operation'     => 'UPDATE',
            'previous_data' => $document->getOriginal(),
            'new_data'      => $document->toArray(),
            'message'       => 'Document updated'
        ]);
    }

    /**
     * Enregistre l'audit lors de la suppression.
     */
    public function deleted(Folder $document)
    {
        AuditLog::create([
            'user_id'       => Auth::id(),
            'auditable_id'  => $document->id,
            'auditable_type'=> get_class($document),
            'operation'     => 'DELETE',
            'previous_data' => $document->toArray(),
            'new_data'      => null,
            'message'       => 'Document deleted'
        ]);
    }
}
