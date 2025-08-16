<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditObserver
{
    private function getLabel($model): string
    {
        foreach (['folder_number', 'invoice_number', 'operation_code', 'name', 'label', 'title'] as $field) {
            if (isset($model->{$field}) && $model->{$field} !== '') {
                return (string) $model->{$field};
            }
        }

        return (string) $model->id;
    }

    /**
     * Enregistre l’audit lors de la création d’un modèle.
     */
    public function created($model)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'auditable_id' => $model->id,
            'auditable_type' => get_class($model),
            'operation' => 'CREATE',
            'previous_data' => null,
            'new_data' => $model->toArray(),
            'message' => 'Création de '.class_basename($model).' ('.$this->getLabel($model).')',
        ]);
    }

    /**
     * Enregistre l’audit lors de la mise à jour d’un modèle.
     */
    public function updated($model)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'auditable_id' => $model->id,
            'auditable_type' => get_class($model),
            'operation' => 'UPDATE',
            'previous_data' => $model->getOriginal(),
            'new_data' => $model->toArray(),
            'message' => 'Mise à jour de '.class_basename($model).' ('.$this->getLabel($model).')',
        ]);
    }

    /**
     * Enregistre l’audit lors de la suppression d’un modèle.
     */
    public function deleted($model)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'auditable_id' => $model->id,
            'auditable_type' => get_class($model),
            'operation' => 'DELETE',
            'previous_data' => $model->toArray(),
            'new_data' => null,
            'message' => 'Suppression de '.class_basename($model).' ('.$this->getLabel($model).')',
        ]);
    }
}
