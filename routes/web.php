<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard\Dashboard;
use App\Livewire\Admin\Company\{CompanyCreate,CompanyIndex,CompanyList,CompanyShow};

Route::get('/', function () {return view('auth.login');});

Route::get('/dashboard', Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::prefix('company')->name('company.')->group(function () {
        Route::get('/index', CompanyIndex::class)->name('index');
        Route::get('/create', CompanyCreate::class)->name('create');
        Route::get('/edit/{id}', CompanyCreate::class)->name('edit');
        Route::get('/', CompanyCreate::class)->name('index');
        Route::get('/list', CompanyList::class)->name('list');
        Route::get('/show/{id}', CompanyShow::class)->name('show');
        Route::get('/delete/{id}', CompanyCreate::class)->name('delete');
        Route::get('/restore/{id}', CompanyCreate::class)->name('restore');
    });

});

require __DIR__.'/auth.php';
