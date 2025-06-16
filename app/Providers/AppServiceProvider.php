<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\DocumentType;
use App\Models\Folder;
use App\Models\FolderFile;
use App\Observers\AuditObserver;
use App\Observers\DocumentTypeObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Allow all Gate checks to pass so pages are temporarily public
        Gate::before(fn () => true);

        Paginator::useTailwind();

        DocumentType::observe(DocumentTypeObserver::class);
    }
}
