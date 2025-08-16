<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Folder;
use App\Models\Invoice;
use App\Models\GlobalInvoice;
use App\Models\Licence;
use App\Models\Company;
use App\Models\FolderFile;
use App\Models\Bivac;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $expiringSoonLicences = 0;
    public $activeLicences = 0;
    public array $capacityAlerts = [];

    public function render()
    {
        // Licences actives et expirant bientôt
        $this->activeLicences = Licence::where(function ($q) {
            $q->whereNull('expiry_date')->orWhere('expiry_date', '>=', Carbon::today());
        })->count();

        $this->expiringSoonLicences = Licence::whereNotNull('expiry_date')
            ->whereBetween('expiry_date', [Carbon::today(), Carbon::today()->addDays(30)])
            ->count();

        $this->capacityAlerts = Licence::all()->map(function ($licence) {
            $weightUsed = $licence->initial_weight > 0 ? 100 - ($licence->remaining_weight / $licence->initial_weight * 100) : 0;
            $fobUsed = $licence->initial_fob_amount > 0 ? 100 - ($licence->remaining_fob_amount / $licence->initial_fob_amount * 100) : 0;
            if ($weightUsed >= 80 || $fobUsed >= 80) {
                return [
                    'license_number' => $licence->license_number,
                    'weightUsed' => $weightUsed,
                    'fobUsed' => $fobUsed,
                ];
            }
            return null;
        })->filter()->values()->toArray();

        // Statistiques dossiers
        $totalFolders = Folder::count();
        $foldersThisMonth = Folder::where('created_at', '>=', Carbon::now()->startOfMonth())->count();

        // Statistiques factures
        $totalInvoices = Invoice::count();
        $invoicesThisMonth = Invoice::where('created_at', '>=', Carbon::now()->startOfMonth())->count();

        // Statistiques globales
        $totalGlobalInvoices = GlobalInvoice::count();
        $totalCompanies = Company::notDeleted()->count();

        // BIVAC
        $totalBivacs = Bivac::count();
        $latestBivacs = Bivac::latest()->take(5)->get();

        // Fichiers
        $totalUploadedFiles = FolderFile::count();
        $filesThisMonth = FolderFile::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        $latestFiles = FolderFile::with('documentType')->latest()->take(5)->get();

        // Derniers enregistrements
        $latestFolders = Folder::with('company')->latest()->take(5)->get();
        $latestInvoices = Invoice::with('company')->latest()->take(5)->get();
        $latestGlobalInvoices = GlobalInvoice::with('company')->latest()->take(5)->get();
        $latestCompanies = Company::notDeleted()->latest()->take(5)->get();

        // Éléments archivés récents
        $archivedFolders = Folder::onlyTrashed()->latest()->take(5)->get();
        $archivedInvoices = Invoice::onlyTrashed()->latest()->take(5)->get();
        $archivedGlobalInvoices = GlobalInvoice::onlyTrashed()->latest()->take(5)->get();

        $archivedFoldersCount = Folder::onlyTrashed()->count();
        $archivedInvoicesCount = Invoice::onlyTrashed()->count();
        $archivedGlobalInvoicesCount = GlobalInvoice::onlyTrashed()->count();

        return view('livewire.admin.dashboard.dashboard', [
            'totalFolders' => $totalFolders,
            'foldersThisMonth' => $foldersThisMonth,
            'totalInvoices' => $totalInvoices,
            'invoicesThisMonth' => $invoicesThisMonth,
            'totalGlobalInvoices' => $totalGlobalInvoices,
            'totalCompanies' => $totalCompanies,
            'activeLicences' => $this->activeLicences,
            'expiringSoonLicences' => $this->expiringSoonLicences,
            'capacityAlerts' => $this->capacityAlerts,
            'totalUploadedFiles' => $totalUploadedFiles,
            'filesThisMonth' => $filesThisMonth,
            'latestFolders' => $latestFolders,
            'latestInvoices' => $latestInvoices,
            'latestGlobalInvoices' => $latestGlobalInvoices,
            'latestCompanies' => $latestCompanies,
            'latestFiles' => $latestFiles,
            'totalBivacs' => $totalBivacs,
            'latestBivacs' => $latestBivacs,
            'archivedFolders' => $archivedFolders,
            'archivedInvoices' => $archivedInvoices,
            'archivedGlobalInvoices' => $archivedGlobalInvoices,
            'archivedFoldersCount' => $archivedFoldersCount,
            'archivedInvoicesCount' => $archivedInvoicesCount,
            'archivedGlobalInvoicesCount' => $archivedGlobalInvoicesCount,
        ]);
    }
}
