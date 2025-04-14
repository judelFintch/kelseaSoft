<?php

namespace App\Services\Folder;

use App\Models\Folder;


class FolderService
{
    public function createFolder($name, $parentId = null)
    {
        return Folder::create([
            'name' => $name,
            'parent_id' => $parentId,
        ]);
    }

    public function getFolder($id)
    {
        return Folder::findOrFail($id);
    }

    public function updateFolder($id, $data)
    {
        $folder = $this->getFolder($id);
        $folder->update($data);
        return $folder;
    }

    public function deleteFolder($id)
    {
        $folder = $this->getFolder($id);
        return $folder->delete();
    }


    public static function generateFolderNumber()
    {
        $lastFolder = Folder::orderBy('created_at', 'desc')->first();
        if ($lastFolder) {
            $lastNumber = (int) substr($lastFolder->folder_number, 1);
            $newNumber = $lastNumber + 1;
            return 'F' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
        }
        return 'F00001';
    }

    public static function storeFolder($data)
    {
        return Folder::create($data);
    }
      
}