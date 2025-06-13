<?php

namespace App\Services\Folder;

use App\Models\Folder;
use App\Models\Licence;
use App\Services\Licence\LicenceService;
use Illuminate\Support\Facades\DB;
use App\Enums\DossierType;

class FolderService
{
    public function createFolder($name, $parentId = null)
    {
        return Folder::create([
            'name' => $name,
            'parent_id' => $parentId,
        ]);
    }

    public static function getFolder($id)
    {
        return Folder::with([
            'transporter',
            'supplier',
            'origin',
            'destination',
            'customsOffice',
            'declarationType',
            'company',
            'files.documentType',
        ])->findOrFail($id);
    }

    public function deleteFolder($id)
    {
        $folder = $this->getFolder($id);

        return $folder->delete();
    }

    public static function generateFolderNumber(): string
    {
        return 'FD-' . strtoupper(uniqid());
    }

    public static function storeFolder(array $data): Folder
    {
        return DB::transaction(function () use ($data) {
            $fob = floatval($data['fob_amount'] ?? 0);
            $insurance = floatval($data['insurance_amount'] ?? 0);
            $freight = floatval($data['freight_amount'] ?? 0);
            $data['cif_amount'] = $fob + $insurance + $freight;

            $folder = Folder::create($data);

            // Attachement à une licence si dossier type "avec"
            if (($data['dossier_type'] ?? null) === DossierType::AVEC->value && isset($data['license_id'])) {
                $license = Licence::find($data['license_id']);

                if (!$license || !app(LicenceService::class)->attachFolderToLicense($folder, $license)) {
                    $folder->delete();
                    throw new \Exception("La licence ne peut pas supporter ce dossier (poids, FOB ou quantité insuffisants).");
                }
            }

            return $folder;
        });
    }

    public static function updateFolder(Folder $folder, array $data): Folder
    {
        $data['cif_amount'] =
            ($data['fob_amount'] ?? $folder->fob_amount ?? 0) +
            ($data['insurance_amount'] ?? $folder->insurance_amount ?? 0) +
            ($data['freight_amount'] ?? $folder->freight_amount ?? 0);

        // Only update attributes that are fillable on the model
        $folder->update($data);

        return $folder;
    }
}
