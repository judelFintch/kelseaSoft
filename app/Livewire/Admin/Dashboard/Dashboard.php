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
    public function render()
    {
        // Statistiques
        $totalFolders = Folder::count();
        $foldersThisMonth = Folder::where('created_at', '>=', Carbon::now()->startOfMonth())->count();

        $totalInvoices = Invoice::count(); // Factures individuelles
        $invoicesThisMonth = Invoice::where('created_at', '>=', Carbon::now()->startOfMonth())->count();

        $totalGlobalInvoices = GlobalInvoice::count();

        // Pour les licences, supposons qu'il n'y a pas de champ de statut 'active' pour l'instant.
        // Si un champ comme `status = 'active'` existe, il faudrait l'ajouter aux conditions where.
        $activeLicences = Licence::where('expiry_date', '>=', Carbon::now())->count();
        $expiringSoonLicences = Licence::whereBetween('expiry_date', [Carbon::now(), Carbon::now()->addDays(30)])->count();

        // Listes Récentes (les 5 derniers)
        // Assurez-vous que la relation vers Company dans Folder, Invoice, GlobalInvoice est bien 'company'.
        // Si elle est différente (ex: 'client'), ajustez ->with('client') en conséquence.
        $latestFolders = Folder::with('company')->latest()->take(5)->get();
        $latestInvoices = Invoice::with('company')->latest()->take(5)->get();
        $latestGlobalInvoices = GlobalInvoice::with('company')->latest()->take(5)->get();

        // Ajout de Statistiques Clients
        $totalCompanies = Company::count();

        // Ajout de Liste Récente Clients
        $latestCompanies = Company::latest()->take(5)->get();

        return view('livewire.admin.dashboard.dashboard', compact(
            'totalFolders',
            'foldersThisMonth',
            'totalInvoices',
            'invoicesThisMonth',
            'totalGlobalInvoices',
            'activeLicences',
            'expiringSoonLicences',
            'latestFolders',
            'latestInvoices',
            'latestGlobalInvoices',
            'totalCompanies', // Ajout de totalCompanies au compact
            'latestCompanies'  // Ajout de latestCompanies au compact
        ));
    }
}
