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
}