<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Trucks\{ListTrucks, CreateTruck, EditTruck, ShowTruck, DeleteTruck};
use App\Livewire\Files\{ListFiles, CreateFile, EditFile, ShowFile, DeleteFile};
use App\Livewire\Invoices\{ListInvoices, CreateInvoice, EditInvoice, ShowInvoice, DeleteInvoice};
use App\Livewire\Payments\{ListPayments, CreatePayment, EditPayment, ShowPayment, DeletePayment};
use App\Livewire\Clients\{ListClients, CreateClient, EditClient, ShowClient, DeleteClient};
use App\Livewire\Settings\{ProfileSettings, SystemSettings, NotificationSettings};
use App\Livewire\Dossiers\{ListDossiers,ShowDossier,CreateDossier,EditDossier};

Route::get('/', function () {return view('welcome');})->name('home');

Route::view('dashboard', 'dashboard') ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    

    // Gestion des camions
    Route::prefix('trucks')->name('trucks.')->group(function () {
        Route::get('/', ListTrucks::class)->name('index');
        Route::get('/create', CreateTruck::class)->name('create');
        Route::get('/{truck}/edit', EditTruck::class)->name('edit');
        Route::get('/{truck}', ShowTruck::class)->name('show');
        Route::get('/{truck}/delete', DeleteTruck::class)->name('delete');
    });

    // Gestion des dossiers
    Route::prefix('files')->name('files.')->group(function () {
        Route::get('/', ListFiles::class)->name('index');
        Route::get('/create', CreateFile::class)->name('create');
        Route::get('/{file}/edit', EditFile::class)->name('edit');
        Route::get('/{file}', ShowFile::class)->name('show');
        Route::get('/{file}/delete', DeleteFile::class)->name('delete');
    });

    // Gestion des factures
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', ListInvoices::class)->name('index');
        Route::get('/create', CreateInvoice::class)->name('create');
        Route::get('/{invoice}/edit', EditInvoice::class)->name('edit');
        Route::get('/{invoice}', ShowInvoice::class)->name('show');
        Route::get('/{invoice}/delete', DeleteInvoice::class)->name('delete');
    });

    //  Gestion des paiements
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', ListPayments::class)->name('index');
        Route::get('/create', CreatePayment::class)->name('create');
        Route::get('/{payment}/edit', EditPayment::class)->name('edit');
        Route::get('/{payment}', ShowPayment::class)->name('show');
        Route::get('/{payment}/delete', DeletePayment::class)->name('delete');
    });

    // Gestion des clients
    Route::prefix('clients')->name('clients.')->group(function () {
        Route::get('/', ListClients::class)->name('index');
        Route::get('/create', CreateClient::class)->name('create');
        Route::get('/{client}/edit', EditClient::class)->name('edit');
        Route::get('/{client}', ShowClient::class)->name('show');
        Route::get('/{client}/delete', DeleteClient::class)->name('delete');
    });

    Route::prefix('dossiers')->group(function () {
        Route::get('/', ListDossiers::class)->name('dossiers.index'); // Liste des dossiers
        Route::get('/create', CreateDossier::class)->name('dossiers.create'); // Création d'un dossier
        Route::get('/{dossier}', ShowDossier::class)->name('dossiers.show'); // Détail d'un dossier
        Route::get('/{dossier}/edit', EditDossier::class)->name('dossiers.edit'); // Modification d'un dossier
    });

   


    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
