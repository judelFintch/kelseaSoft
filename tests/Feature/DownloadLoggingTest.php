<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Folder;
use App\Livewire\Admin\Invoices\ShowInvoice;
use App\Livewire\Admin\Folder\FolderTransactions;
use App\Livewire\Admin\Backup\BackupIndex;

class DownloadLoggingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function invoice_download_is_logged(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $invoice = Invoice::factory()->for($company)->create();

        $this->actingAs($user);

        Livewire::test(ShowInvoice::class, ['invoice' => $invoice])
            ->call('downloadPdf');

        $this->assertDatabaseHas('download_logs', [
            'user_id' => $user->id,
            'file_type' => 'invoice',
            'file_id' => $invoice->id,
            'ip' => '127.0.0.1',
        ]);
    }

    /** @test */
    public function folder_transactions_download_is_logged(): void
    {
        $user = User::factory()->create();
        $folder = Folder::factory()->create();

        $this->actingAs($user);

        Livewire::test(FolderTransactions::class, ['folder' => $folder])
            ->call('downloadPdf');

        $this->assertDatabaseHas('download_logs', [
            'user_id' => $user->id,
            'file_type' => 'folder_transactions',
            'file_id' => $folder->id,
            'ip' => '127.0.0.1',
        ]);
    }

    /** @test */
    public function backup_download_is_logged(): void
    {
        $user = User::factory()->create();
        Storage::fake('local');
        config(['backup.path' => Storage::disk('local')->path('backups')]);
        Storage::disk('local')->put('backups/test.sql', 'dummy');

        $this->actingAs($user);

        Livewire::test(BackupIndex::class)
            ->call('download', 'test.sql');

        $this->assertDatabaseHas('download_logs', [
            'user_id' => $user->id,
            'file_type' => 'backup',
            'file_id' => null,
            'ip' => '127.0.0.1',
        ]);
    }
}
