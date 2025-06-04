<?php

namespace Tests\Feature\Livewire\Admin\Permission;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Livewire\Livewire;
use App\Livewire\Admin\Permission\PermissionIndex;
use Illuminate\Support\Facades\Artisan;

class PermissionIndexTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);
        $this->adminUser = User::where('email', 'root@example.com')->first();
    }

    public function test_permission_index_renders_successfully_for_authorized_user()
    {
        $this->actingAs($this->adminUser);
        Livewire::test(PermissionIndex::class)
            ->assertStatus(200)
            ->assertViewIs('livewire.admin.permission.permission-index')
            ->assertSee('Permissions');
    }

    public function test_permission_index_is_protected_for_unauthorized_user()
    {
        $unauthorizedUser = User::factory()->create();
        $this->actingAs($unauthorizedUser);

        Livewire::test(PermissionIndex::class)
            ->assertStatus(403);
    }

    public function test_permission_index_displays_permissions()
    {
        $this->actingAs($this->adminUser);
        // Permissions are seeded by DatabaseSeeder, so we check for some known ones
        Permission::factory()->create(['name' => 'perm_x', 'display_name' => 'Permission X Test']);
        Permission::factory()->create(['name' => 'perm_y', 'display_name' => 'Permission Y Test']);


        Livewire::test(PermissionIndex::class)
            ->assertSee('Permission X Test')
            ->assertSee('Permission Y Test')
            ->assertSee('manage users'); // From seeder
    }

    public function test_permission_index_search_filters_permissions()
    {
        $this->actingAs($this->adminUser);
        Permission::factory()->create(['name' => 'searchable_one', 'display_name' => 'Searchable One Perm']);
        Permission::factory()->create(['name' => 'another_perm_xyz', 'display_name' => 'Another Permission XYZ']);

        Livewire::test(PermissionIndex::class)
            ->set('search', 'Searchable One Perm')
            ->assertSee('Searchable One Perm')
            ->assertDontSee('Another Permission XYZ');

        Livewire::test(PermissionIndex::class)
            ->set('search', 'manage roles') // from seeder
            ->assertSee('manage roles')
            ->assertDontSee('Searchable One Perm');
    }
}
