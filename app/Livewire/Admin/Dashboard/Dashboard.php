<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Folder;
use App\Models\Invoice;
use App\Models\GlobalInvoice;
use App\Models\Licence;
use App\Models\Company;
use App\Models\FolderFile;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $expiringSoonLicences = 1;
    public $activeLicences = 1;

    public function render()
    {
        // Statistiques dossiers
        $totalFolders = Folder::count();
        $foldersThisMonth = Folder::where('created_at', '>=', Carbon::now()->startOfMonth())->count();

        // Statistiques factures
        $totalInvoices = Invoice::count();
        $invoicesThisMonth = Invoice::where('created_at', '>=', Carbon::now()->startOfMonth())->count();

        // Statistiques globales
        $totalGlobalInvoices = GlobalInvoice::count();
        $totalCompanies = Company::count();

        // Fichiers
        $totalUploadedFiles = FolderFile::count();
        $filesThisMonth = FolderFile::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        $latestFiles = FolderFile::with('documentType')->latest()->take(5)->get();

        // Derniers enregistrements
        $latestFolders = Folder::with('company')->latest()->take(5)->get();
        $latestInvoices = Invoice::with('company')->latest()->take(5)->get();
        $latestGlobalInvoices = GlobalInvoice::with('company')->latest()->take(5)->get();
        $latestCompanies = Company::latest()->take(5)->get();

        return view('livewire.admin.dashboard.dashboard', [
            'totalFolders' => $totalFolders,
            'foldersThisMonth' => $foldersThisMonth,
            'totalInvoices' => $totalInvoices,
            'invoicesThisMonth' => $invoicesThisMonth,
            'totalGlobalInvoices' => $totalGlobalInvoices,
            'totalCompanies' => $totalCompanies,
            'activeLicences' => $this->activeLicences,
            'expiringSoonLicences' => $this->expiringSoonLicences,
            'totalUploadedFiles' => $totalUploadedFiles,
            'filesThisMonth' => $filesThisMonth,
            'latestFolders' => $latestFolders,
            'latestInvoices' => $latestInvoices,
            'latestGlobalInvoices' => $latestGlobalInvoices,
            'latestCompanies' => $latestCompanies,
            'latestFiles' => $latestFiles,
        ]);
    }
}
