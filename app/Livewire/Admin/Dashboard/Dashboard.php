<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Folder;
use App\Models\Invoice;
use App\Models\GlobalInvoice;
use App\Models\Licence;
use App\Models\Company; // Ajout du modèle Company
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{

    public $expiringSoonLicences =1;
    public $activeLicences = 1;
   public function render()
{
    // Statistiques
    $totalFolders = Folder::count();
    $foldersThisMonth = Folder::where('created_at', '>=', Carbon::now()->startOfMonth())->count();

    $totalInvoices = Invoice::count();
    $invoicesThisMonth = Invoice::where('created_at', '>=', Carbon::now()->startOfMonth())->count();

    $totalGlobalInvoices = GlobalInvoice::count();
    $totalCompanies = Company::count();

    // Licences
   // $this->activeLicences = Licence::where('expiry_date', '>=', Carbon::now())->count();
   // $this->expiringSoonLicences = Licence::whereBetween('expiry_date', [Carbon::now(), Carbon::now()->addDays(30)])->count();

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
        'latestFolders' => $latestFolders,
        'latestInvoices' => $latestInvoices,
        'latestGlobalInvoices' => $latestGlobalInvoices,
        'latestCompanies' => $latestCompanies,
    ]);
}
}
