<?php

namespace Tests\Feature\Livewire\Admin\Role;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Livewire\Livewire;
use App\Livewire\Admin\Role\RoleIndex;
use Illuminate\Support\Facades\Artisan;

class RoleIndexTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);
        $this->adminUser = User::where('email', 'root@example.com')->first();
    }

    public function test_role_index_renders_successfully_for_authorized_user()
    {
        $this->actingAs($this->adminUser);
        Livewire::test(RoleIndex::class)
            ->assertStatus(200)
            ->assertViewIs('livewire.admin.role.role-index')
            ->assertSee('Roles');
    }

    public function test_role_index_is_protected_for_unauthorized_user()
    {
        $unauthorizedUser = User::factory()->create();
        $this->actingAs($unauthorizedUser);

        Livewire::test(RoleIndex::class)
            ->assertStatus(403);
    }

    public function test_role_index_displays_roles()
    {
        $this->actingAs($this->adminUser);
        Role::factory()->create(['name' => 'Editor Role', 'display_name' => 'Editor']);
        Role::factory()->create(['name' => 'Viewer Role', 'display_name' => 'Viewer']);

        Livewire::test(RoleIndex::class)
            ->assertSee('Editor Role')
            ->assertSee('Viewer Role');
    }

    public function test_role_index_search_filters_roles()
    {
        $this->actingAs($this->adminUser);
        Role::factory()->create(['name' => 'alpha_role', 'display_name' => 'Alpha']);
        Role::factory()->create(['name' => 'beta_role', 'display_name' => 'Beta']);

        Livewire::test(RoleIndex::class)
            ->set('search', 'Alpha')
            ->assertSee('alpha_role')
            ->assertDontSee('beta_role');
    }

    public function test_can_delete_role_from_index()
    {
        $this->actingAs($this->adminUser);
        $roleToDelete = Role::factory()->create(['name' => 'temporary_role']);

        Livewire::test(RoleIndex::class)
            ->call('deleteRole', $roleToDelete->id)
            ->assertEmitted('message')
            ->assertDontSee($roleToDelete->name);

        $this->assertDatabaseMissing('roles', ['id' => $roleToDelete->id]);
    }

    public function test_cannot_delete_root_role()
    {
        $this->actingAs($this->adminUser);
        $rootRole = Role::where('name', 'root')->first();

        Livewire::test(RoleIndex::class)
            ->call('deleteRole', $rootRole->id)
            ->assertEmitted('error') // Assuming an error flash message is emitted
            ->assertSee($rootRole->name); // Still visible

        $this->assertDatabaseHas('roles', ['id' => $rootRole->id]);
    }
}
