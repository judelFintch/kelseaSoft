<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Admin\Company\CompanyCreate;
use App\Livewire\Admin\Company\CompanyIndex;
use App\Livewire\Admin\Company\CompanyList;
use App\Livewire\Admin\Company\CompanyShow;
use App\Livewire\Admin\Dashboard\Dashboard;
use App\Livewire\Admin\FilesTpesName\FileTypeNameCreate;
use App\Livewire\Admin\Folder\FolderCreate;
use App\Livewire\Admin\Folder\FolderDashboard;
use App\Livewire\Admin\Folder\FolderList;
use App\Livewire\Admin\Folder\FolderShow;
use App\Livewire\Admin\ManageCustomsRegimes\CustomsRegimesCreate;
use App\Livewire\Admin\ManageMerchandiseType\MerchandiseTypeCreate;
use App\Livewire\Admin\ManageSupplier\SupplierCreate;
use App\Livewire\Admin\ManageTransporters\TransportersCreate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('company')->name('company.')->group(function () {
        Route::get('/Dashaboard', CompanyIndex::class)->name('index');
        Route::get('/create', CompanyCreate::class)->name('create');
        Route::get('/edit/{id}', CompanyCreate::class)->name('edit');
        Route::get('/list', CompanyList::class)->name('list');
        Route::get('/show/{id}', CompanyShow::class)->name('show');
        Route::get('/delete/{id}', CompanyCreate::class)->name('delete');
        Route::get('/restore/{id}', CompanyCreate::class)->name('restore');
    });

    Route::prefix('folder')->name('folder.')->group(function () {
        Route::get('/Dashaboard', FolderDashboard::class)->name('index');
        Route::get('/create', FolderCreate::class)->name('create');
        Route::get('/edit/{id}', FolderCreate::class)->name('edit');
        Route::get('/list', FolderList::class)->name('list');
        Route::get('/show/{id}', FolderShow::class)->name('show');
        Route::get('/delete/{id}', FolderCreate::class)->name('delete');
        Route::get('/restore/{id}', FolderCreate::class)->name('restore');
    });

    Route::prefix('fileTypeName')->name('fileTypeName.')->group(function () {
        Route::get('/create', FileTypeNameCreate::class)->name('create');
        Route::get('/edit/{id}', FileTypeNameCreate::class)->name('edit');
        Route::get('/list', FileTypeNameCreate::class)->name('list');
        Route::get('/show/{id}', FileTypeNameCreate::class)->name('show');
        Route::get('/delete/{id}', FileTypeNameCreate::class)->name('delete');
        Route::get('/restore/{id}', FileTypeNameCreate::class)->name('restore');
    });

    Route::prefix('merchandiseType')->name('merchandiseType.')->group(function () {
        Route::get('/create', MerchandiseTypeCreate::class)->name('create');
        Route::get('/edit/{id}', MerchandiseTypeCreate::class)->name('edit');
        Route::get('/list', MerchandiseTypeCreate::class)->name('list');
        Route::get('/show/{id}', MerchandiseTypeCreate::class)->name('show');
        Route::get('/delete/{id}', MerchandiseTypeCreate::class)->name('delete');
        Route::get('/restore/{id}', MerchandiseTypeCreate::class)->name('restore');
    });

    Route::prefix('customsRegimes')->name('customsRegimes.')->group(function () {
        Route::get('/create', CustomsRegimesCreate::class)->name('create');
        Route::get('/edit/{id}', CustomsRegimesCreate::class)->name('edit');
        Route::get('/list', CustomsRegimesCreate::class)->name('list');
        Route::get('/show/{id}', CustomsRegimesCreate::class)->name('show');
        Route::get('/delete/{id}', CustomsRegimesCreate::class)->name('delete');
        Route::get('/restore/{id}', CustomsRegimesCreate::class)->name('restore');
    });

    Route::prefix('supplier')->name('supplier.')->group(function () {
        Route::get('/create', SupplierCreate::class)->name('create');
        Route::get('/edit/{id}', SupplierCreate::class)->name('edit');
        Route::get('/list', SupplierCreate::class)->name('list');
        Route::get('/show/{id}', SupplierCreate::class)->name('show');
        Route::get('/delete/{id}', SupplierCreate::class)->name('delete');
        Route::get('/restore/{id}', SupplierCreate::class)->name('restore');
    });

    Route::prefix('manageTransporter')->name('transporter.')->group(function () {
        Route::get('/create', TransportersCreate::class)->name('create');
        Route::get('/edit/{id}', TransportersCreate::class)->name('edit');
        Route::get('/list', TransportersCreate::class)->name('list');
        Route::get('/show/{id}', TransportersCreate::class)->name('show');
        Route::get('/delete/{id}', TransportersCreate::class)->name('delete');
        Route::get('/restore/{id}', TransportersCreate::class)->name('restore');
    });

});

require __DIR__.'/auth.php';
