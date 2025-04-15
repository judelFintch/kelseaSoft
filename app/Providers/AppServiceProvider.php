<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\DocumentType;
use App\Models\Folder;
use App\Models\FolderFile;
use App\Observers\AuditObserver;
use Illuminate\Pagination\Paginator;
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
        //
        Paginator::useTailwind();
        Folder::observe(AuditObserver::class);
        DocumentType::observe(AuditObserver::class);
        FolderFile::observe(AuditObserver::class);
        Company::observe(AuditObserver::class);
    }
}
