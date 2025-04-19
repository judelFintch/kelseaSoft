<?php

namespace App\Services\Licence;

use App\Models\Licence;
use App\Models\Folder;
use Illuminate\Support\Facades\DB;
use App\Models\FoldeLicence;

class LicenceService
{
    public function attachFolderToLicense(Folder $folder, Licence $license): bool
    {
        return DB::transaction(function () use ($folder, $license) {
            $weight = (float) ($folder->weight ?? 0);
            $fob = (float) ($folder->fob_amount ?? 0);
            $qty = (float) ($folder->quantity ?? 0); // Assurez-vous que ce champ existe sur Folder

            if (
                $license->remaining_folders <= 0 ||
                $license->remaining_weight < $weight ||
                $license->remaining_fob_amount < $fob ||
                $license->remaining_quantity < $qty
            ) {
                return false;
            }

            $folder->license_id = $license->id;
            $folder->save();

            $license->remaining_folders--;
            $license->remaining_weight -= $weight;
            $license->remaining_fob_amount -= $fob;
            $license->remaining_quantity -= $qty;
            $license->save();

            FoldeLicence::create([
                'licence_id' => $license->id,
                'folder_id' => $folder->id,
                'fob_used' => $fob,
                'weight_used' => $weight,
                'quantity_used' => $qty,
            ]);

            return true;
        });
    }

    public function detachFolderFromLicense(Folder $folder): bool
    {
        if (!$folder->license_id) {
            return false;
        }

        return DB::transaction(function () use ($folder) {
            $license = Licence::find($folder->license_id);
            $weight = (float) ($folder->weight ?? 0);
            $fob = (float) ($folder->fob_amount ?? 0);
            $qty = (float) ($folder->quantity ?? 0);

            $license->remaining_folders++;
            $license->remaining_weight += $weight;
            $license->remaining_fob_amount += $fob;
            $license->remaining_quantity += $qty;
            $license->save();

            $folder->license_id = null;
            $folder->save();

            return true;
        });
    }

    public static function getLicenseById($id): ?Licence
    {
        return Licence::find($id);
    }

    public static function getAllLicenses(): array
    {
        return Licence::all()->toArray();
    }

    public function createLicense(array $data): Licence
    {
        return Licence::create($data);
    }

    public function updateLicense(Licence $license, array $data): bool
    {
        return $license->update($data);
    }

    public function deleteLicense(Licence $license): bool
    {
        return $license->delete();
    }

    public function restoreLicense(Licence $license): bool
    {
        return $license->restore();
    }
}
