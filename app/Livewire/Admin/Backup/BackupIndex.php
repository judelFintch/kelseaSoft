<?php

namespace App\Livewire\Admin\Backup;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Services\Backup\BackupService;

class BackupIndex extends Component
{
    public function createBackup(): void
    {
        $service = new BackupService();
        $file = $service->backup();
        session()->flash('success', 'Sauvegarde créée : ' . $file);
    }

    public function restoreBackup(string $file): void
    {
        try {
            $service = new BackupService();
            $service->restore($file);
            session()->flash('success', 'Base restaurée depuis ' . $file);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function deleteBackup(string $file): void
    {
        Storage::disk('local')->delete('backups/' . $file);
        session()->flash('success', 'Sauvegarde supprimée.');
    }

    public function download(string $file): StreamedResponse
    {
        $path = storage_path('app/backups/' . $file);
        return response()->download($path);
    }

    public function render()
    {
        $files = collect(Storage::disk('local')->files('backups'))
            ->filter(fn ($f) => str_ends_with($f, '.sql') || str_ends_with($f, '.sqlite'))
            ->map(fn ($f) => basename($f))
            ->sortDesc();

        return view('livewire.admin.backup.backup-index', ['files' => $files]);
    }
}
