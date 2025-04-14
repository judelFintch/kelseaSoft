<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Folder;
use App\Models\DocumentType;
use App\Models\FolderFile;
use App\Models\Company;
use App\Observers\AuditObserver;

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
