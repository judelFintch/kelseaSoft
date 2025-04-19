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
            $data['cif_amount'] = $fob + $insurance;

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
        $folder->update([
            'folder_number' => $data['folder_number'],
            'truck_number' => $data['truck_number'],
            'trailer_number' => $data['trailer_number'] ?? null,
            'transporter_id' => $data['transporter_id'] ?? null,
            'driver_name' => $data['driver_name'] ?? null,
            'driver_phone' => $data['driver_phone'] ?? null,
            'driver_nationality' => $data['driver_nationality'] ?? null,
            'origin_id' => $data['origin_id'] ?? null,
            'destination_id' => $data['destination_id'] ?? null,
            'supplier_id' => $data['supplier_id'] ?? null,
            'client' => $data['client'] ?? null,
            'customs_office_id' => $data['customs_office_id'] ?? null,
            'declaration_number' => $data['declaration_number'] ?? null,
            'declaration_type_id' => $data['declaration_type_id'] ?? null,
            'declarant' => $data['declarant'] ?? null,
            'customs_agent' => $data['customs_agent'] ?? null,
            'container_number' => $data['container_number'] ?? null,
            'weight' => $data['weight'] ?? 0,
            'fob_amount' => $data['fob_amount'] ?? 0,
            'insurance_amount' => $data['insurance_amount'] ?? 0,
            'cif_amount' => $data['cif_amount'] ?? 0,
            'arrival_border_date' => $data['arrival_border_date'] ?? null,
            'description' => $data['description'] ?? null,
        ]);

        return $folder;
    }
}
