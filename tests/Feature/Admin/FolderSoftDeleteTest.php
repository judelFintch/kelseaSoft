<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Company;
use App\Models\Folder;
use App\Livewire\Admin\Folder\FolderList;
use App\Livewire\Admin\Archive\ArchiveIndex;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FolderSoftDeleteTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Company $company;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->company = Company::factory()->create();
    }

    /** @test */
    public function test_folder_soft_delete_and_restore(): void
    {
        $folder = Folder::factory()->for($this->company)->create();

        Livewire::test(FolderList::class)
            ->call('archiveFolder', $folder->id);

        $this->assertSoftDeleted('folders', ['id' => $folder->id]);

        Livewire::test(ArchiveIndex::class)
            ->call('restoreFolder', $folder->id);

        $this->assertDatabaseHas('folders', [
            'id' => $folder->id,
            'deleted_at' => null,
        ]);
    }
}
