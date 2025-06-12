<?php

namespace App\Livewire\Admin\Archive;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Folder;
use App\Models\Invoice;
use App\Models\GlobalInvoice;

class ArchiveIndex extends Component
{
    use WithPagination;

    public function restoreFolder(int $id): void
    {
        $folder = Folder::onlyTrashed()->findOrFail($id);
        $folder->restore();
        session()->flash('success', 'Dossier restauré avec succès.');
    }

    public function restoreInvoice(int $id): void
    {
        $invoice = Invoice::onlyTrashed()->findOrFail($id);
        $invoice->restore();
        session()->flash('success', 'Facture restaurée avec succès.');
    }

    public function restoreGlobalInvoice(int $id): void
    {
        $globalInvoice = GlobalInvoice::onlyTrashed()->findOrFail($id);
        $globalInvoice->restore();
        session()->flash('success', 'Facture globale restaurée avec succès.');
    }

    public function render()
    {
        return view('livewire.admin.archive.archive-index', [
            'trashedFolders' => Folder::onlyTrashed()->paginate(10),
            'trashedInvoices' => Invoice::onlyTrashed()->with('company')->paginate(10),
            'trashedGlobalInvoices' => GlobalInvoice::onlyTrashed()->with('company')->paginate(10),
            'trashedFoldersCount' => Folder::onlyTrashed()->count(),
            'trashedInvoicesCount' => Invoice::onlyTrashed()->count(),
            'trashedGlobalInvoicesCount' => GlobalInvoice::onlyTrashed()->count(),
        ]);
    }
}
