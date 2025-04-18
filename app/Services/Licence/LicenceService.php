<?php

namespace App\Services\Licence;

use App\Models\License;
use App\Models\Folder;

class LicenseService
{
    public function attachFolderToLicense(Folder $folder, License $license): bool
    {
        // Vérifier les quotas
        if (
            $license->remaining_folders <= 0 ||
            $license->remaining_weight < $folder->weight ||
            $license->remaining_fob_amount < $folder->fob_amount
        ) {
            return false; // quota dépassé
        }

        // Attacher le dossier
        $folder->license_id = $license->id;
        $folder->save();

        // Décrémenter les quotas
        $license->remaining_folders--;
        $license->remaining_weight -= $folder->weight;
        $license->remaining_fob_amount -= $folder->fob_amount;
        $license->save();

        return true;
    }
}
