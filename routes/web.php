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
use App\Livewire\Admin\Licence\{
    LicenceIndex,
    LicenceCreate,
    LicenceShow,
    LicenceEdit,
    LicenceDelete,
    LicenceRestore
};
use App\Livewire\Admin\Billing\{BillingCreate, BillingIndex};

use App\Livewire\Admin\Invoices\ShowInvoice;
use App\Livewire\Admin\Invoices\GenerateInvoice;
use App\Livewire\Admin\Invoices\InvoiceIndex;
use App\Livewire\Admin\Invoices\UpdateInvoice;
use App\Livewire\Admin\Invoices\GlobalInvoiceIndex; // Ajout pour GlobalInvoiceIndex
use App\Livewire\Admin\Invoices\GlobalInvoiceShow;  // Ajout pour GlobalInvoiceShow

use App\Livewire\Admin\Currency\CurrencyIndex;
use App\Livewire\Admin\Currency\CurrencyUpdate;
use App\Livewire\Admin\Taxes\Taxe;
use App\Livewire\Admin\ManageExtraFees\ExtraFee;
use App\Livewire\Admin\ManageAgencyFees\ManageAgencyFee;
use Illuminate\Support\Facades\Route;

// User, Role, Permission Management Livewire Components
use App\Livewire\Admin\User\UserIndex;
use App\Livewire\Admin\User\UserCreate;
use App\Livewire\Admin\User\UserEdit;
use App\Livewire\Admin\Role\RoleIndex;
use App\Livewire\Admin\Role\RoleCreate;
use App\Livewire\Admin\Role\RoleEdit;
use App\Livewire\Admin\Permission\PermissionIndex;
use App\Livewire\Admin\Permission\PermissionCreate;
use App\Livewire\Admin\Permission\PermissionEdit;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('company')->name('company.')->group(function () {
        Route::get('/Dashaboard', CompanyIndex::class)->name('index')->middleware(['permission:view company']);
        Route::get('/create', CompanyCreate::class)->name('create')->middleware(['permission:create company']);
        Route::get('/edit/{id}', CompanyCreate::class)->name('edit')->middleware(['permission:edit company']);
        Route::get('/list', CompanyList::class)->name('list')->middleware(['permission:view company']);
        Route::get('/show/{id}', CompanyShow::class)->name('show')->middleware(['permission:view company']);
        Route::get('/delete/{id}', CompanyCreate::class)->name('delete')->middleware(['permission:delete company']);
        Route::get('/restore/{id}', CompanyCreate::class)->name('restore')->middleware(['permission:delete company']); // Assuming restore is a form of undelete
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
    });

    Route::prefix('manageTransporter')->name('transporter.')->group(function () {
        Route::get('/create', TransportersCreate::class)->name('create');
    });

    Route::prefix('licence')->name('licence.')->group(function () {
        Route::get('/list', LicenceIndex::class)->name('list');
        Route::get('/create', LicenceCreate::class)->name('create');
        Route::get('/show/{id}', LicenceShow::class)->name('show');
        Route::get('/edit/{id}', LicenceEdit::class)->name('edit');
    });


    Route::prefix('billing')->name('billing.')->group(function () {
        Route::get('/create', BillingCreate::class)->name('create');
        Route::get('/edit/{id}', BillingCreate::class)->name('edit');
        Route::get('/list', BillingIndex::class)->name('list');
        Route::get('/show/{id}', BillingCreate::class)->name('show');
        Route::get('/delete/{id}', BillingCreate::class)->name('delete');
        Route::get('/restore/{id}', BillingCreate::class)->name('restore');
    });


    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/invoices/{invoice}/show', ShowInvoice::class)->name('show');
        Route::get('/generate/{folder}', GenerateInvoice::class)->name('generate');
        Route::get('/download/{invoiceId}', [GenerateInvoice::class, 'downloadPdf'])->name('download');
        Route::get('/index', InvoiceIndex::class)->name('index');
        Route::get('/invoices/{invoice}/edit', UpdateInvoice::class)->name('invoices.edit');
    });

    Route::prefix('currency')->name('currency.')->group(function () {

        Route::get('/edit/{id}', CurrencyUpdate::class)->name('edit');
        Route::get('/list', CurrencyIndex::class)->name('list');
        Route::get('/show/{id}', CurrencyUpdate::class)->name('show');
        Route::get('/delete/{id}', CurrencyUpdate::class)->name('delete');
        Route::get('/restore/{id}', CurrencyUpdate::class)->name('restore');
    });

    // Routes pour la facturation globale
    Route::prefix('admin/global-invoices')->name('admin.global-invoices.')->group(function () {
        Route::get('/', GlobalInvoiceIndex::class)->name('index');
        Route::get('/{globalInvoice}', GlobalInvoiceShow::class)->name('show');
        Route::get('/{globalInvoice}/download', [GlobalInvoiceShow::class, 'downloadPdf'])->name('download');
    });

    Route::prefix('taxes')->name('taxes.')->group(function () {
        Route::get('/index', Taxe::class)->name('index');
    });
    Route::prefix('extra-fees')->name('extra-fees.')->group(function () {
        Route::get('/index', ExtraFee::class)->name('index');
    });
    Route::prefix('agency-fees')->name('agency-fees.')->group(function () {
        Route::get('/index', ManageAgencyFee::class)->name('index');
    });

    Route::prefix('agents')->name('agents.')->group(function () {
        Route::get('/list', \App\Livewire\Admin\Agent\AgentIndex::class)->name('list');
        Route::get('/create', \App\Livewire\Admin\Agent\AgentCreate::class)->name('create');
    });

    Route::prefix('payrolls')->name('payrolls.')->group(function () {
        Route::get('/list', \App\Livewire\Admin\Payroll\PayrollIndex::class)->name('list');
        Route::get('/create', \App\Livewire\Admin\Payroll\PayrollCreate::class)->name('create');
    });

    // Admin Routes for User, Role, Permission Management
    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
        // User Management
        Route::prefix('users')->name('user.')->middleware(['permission:manage users'])->group(function () {
            Route::get('/', UserIndex::class)->name('index');
            Route::get('/create', UserCreate::class)->name('create');
            Route::get('/{user}/edit', UserEdit::class)->name('edit');
        });

        // Role Management
        Route::prefix('roles')->name('role.')->middleware(['permission:manage roles'])->group(function () {
            Route::get('/', RoleIndex::class)->name('index');
            Route::get('/create', RoleCreate::class)->name('create');
            Route::get('/{role}/edit', RoleEdit::class)->name('edit');
        });

        // Permission Management
        Route::prefix('permissions')->name('permission.')->middleware(['permission:manage permissions'])->group(function () {
            Route::get('/', PermissionIndex::class)->name('index');
            // Optional: Routes for creating/editing permissions if enabled
            // Route::get('/create', PermissionCreate::class)->name('create');
            // Route::get('/{permission}/edit', PermissionEdit::class)->name('edit');
        });
    });
});

require __DIR__ . '/auth.php';
