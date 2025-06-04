<?php

namespace Tests\Feature\Livewire\Admin\Role;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Livewire\Livewire;
use App\Livewire\Admin\Role\RoleCreate;
use Illuminate\Support\Facades\Artisan;

class RoleCreateTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);
        $this->adminUser = User::where('email', 'root@example.com')->first();
    }

    public function test_role_create_renders_successfully_for_authorized_user()
    {
        $this->actingAs($this->adminUser);
        Livewire::test(RoleCreate::class)
            ->assertStatus(200)
            ->assertViewIs('livewire.admin.role.role-create')
            ->assertSee('Create Role');
    }

    public function test_role_create_is_protected_for_unauthorized_user()
    {
        $unauthorizedUser = User::factory()->create();
        $this->actingAs($unauthorizedUser);

        Livewire::test(RoleCreate::class)
            ->assertStatus(403);
    }

    public function test_can_create_role_without_permissions()
    {
        $this->actingAs($this->adminUser);

        Livewire::test(RoleCreate::class)
            ->set('name', 'new_role')
            ->set('display_name', 'New Role')
            ->set('description', 'A brand new role.')
            ->call('createRole')
            ->assertRedirect(route('admin.role.index'));

        $this->assertDatabaseHas('roles', [
            'name' => 'new_role',
            'display_name' => 'New Role',
        ]);
        $newRole = Role::where('name', 'new_role')->first();
        $this->assertTrue($newRole->permissions->isEmpty());
    }

    public function test_can_create_role_with_permissions()
    {
        $this->actingAs($this->adminUser);
        $perm1 = Permission::factory()->create(['name' => 'perm_one']);
        $perm2 = Permission::factory()->create(['name' => 'perm_two']);

        Livewire::test(RoleCreate::class)
            ->set('name', 'permissioned_role')
            ->set('display_name', 'Permissioned Role')
            ->set('selectedPermissions', [$perm1->id, $perm2->id])
            ->call('createRole')
            ->assertRedirect(route('admin.role.index'));

        $this->assertDatabaseHas('roles', ['name' => 'permissioned_role']);
        $newRole = Role::where('name', 'permissioned_role')->first();
        $this->assertCount(2, $newRole->permissions);
        $this->assertTrue($newRole->permissions->contains($perm1));
        $this->assertTrue($newRole->permissions->contains($perm2));
    }

    public function test_role_creation_validation_errors()
    {
        $this->actingAs($this->adminUser);
        Role::factory()->create(['name' => 'existing_role']); // for unique validation

        Livewire::test(RoleCreate::class)
            ->set('name', '') // Name is required
            ->call('createRole')
            ->assertHasErrors(['name']);

        Livewire::test(RoleCreate::class)
            ->set('name', 'existing_role') // Name must be unique
            ->call('createRole')
            ->assertHasErrors(['name' => 'unique']);
    }
}
