<?php

namespace Tests\Feature\Livewire\Admin\Role;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Livewire\Livewire;
use App\Livewire\Admin\Role\RoleEdit;
use Illuminate\Support\Facades\Artisan;

class RoleEditTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected Role $roleToEdit;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);
        $this->adminUser = User::where('email', 'root@example.com')->first();
        $this->roleToEdit = Role::factory()->create(['name' => 'editor', 'display_name' => 'Editor Role']);
    }

    public function test_role_edit_renders_successfully_for_authorized_user()
    {
        $this->actingAs($this->adminUser);
        Livewire::test(RoleEdit::class, ['role' => $this->roleToEdit])
            ->assertStatus(200)
            ->assertViewIs('livewire.admin.role.role-edit')
            ->assertSee('Edit Role: '. $this->roleToEdit->display_name)
            ->assertSet('name', $this->roleToEdit->name)
            ->assertSet('display_name', $this->roleToEdit->display_name);
    }

    public function test_role_edit_is_protected_for_unauthorized_user()
    {
        $unauthorizedUser = User::factory()->create();
        $this->actingAs($unauthorizedUser);

        Livewire::test(RoleEdit::class, ['role' => $this->roleToEdit])
            ->assertStatus(403);
    }

    public function test_can_update_role_details_and_permissions()
    {
        $this->actingAs($this->adminUser);
        $perm1 = Permission::factory()->create(['name' => 'perm_alpha']);
        $perm2 = Permission::factory()->create(['name' => 'perm_beta']);
        $initialPerm = Permission::factory()->create(['name' => 'initial_perm']);
        $this->roleToEdit->permissions()->attach($initialPerm);

        Livewire::test(RoleEdit::class, ['role' => $this->roleToEdit])
            ->set('name', 'updated_editor')
            ->set('display_name', 'Updated Editor Role')
            ->set('description', 'New description')
            ->set('selectedPermissions', [$perm1->id, $perm2->id])
            ->call('updateRole')
            ->assertRedirect(route('admin.role.index'));

        $this->roleToEdit->refresh();
        $this->assertEquals('updated_editor', $this->roleToEdit->name);
        $this->assertEquals('Updated Editor Role', $this->roleToEdit->display_name);
        $this->assertCount(2, $this->roleToEdit->permissions);
        $this->assertTrue($this->roleToEdit->permissions->contains($perm1));
        $this->assertTrue($this->roleToEdit->permissions->contains($perm2));
        $this->assertFalse($this->roleToEdit->permissions->contains($initialPerm));
    }

    public function test_cannot_change_name_of_root_role()
    {
        $this->actingAs($this->adminUser);
        $rootRole = Role::where('name', 'root')->first();

        Livewire::test(RoleEdit::class, ['role' => $rootRole])
            ->set('name', 'new_root_name')
            ->set('display_name', 'New Root Display Name')
            ->call('updateRole')
            ->assertEmitted('error'); // Should emit an error

        $rootRole->refresh();
        $this->assertEquals('root', $rootRole->name); // Name should not have changed
    }

     public function test_cannot_change_permissions_of_root_role()
    {
        $this->actingAs($this->adminUser);
        $rootRole = Role::where('name', 'root')->first();
        $initialPermissionsCount = $rootRole->permissions->count();
        $newPerm = Permission::factory()->create(['name' => 'some_new_permission']);

        Livewire::test(RoleEdit::class, ['role' => $rootRole])
            ->set('selectedPermissions', [$newPerm->id]) // Attempt to set only one new permission
            ->call('updateRole');


        $rootRole->refresh();
        $this->assertEquals($initialPermissionsCount, $rootRole->permissions->count());
        $this->assertFalse($rootRole->permissions->contains($newPerm));
    }


    public function test_role_update_validation_errors()
    {
        $this->actingAs($this->adminUser);
        Role::factory()->create(['name' => 'another_role_name']); // for unique test

        Livewire::test(RoleEdit::class, ['role' => $this->roleToEdit])
            ->set('name', '') // Name is required
            ->call('updateRole')
            ->assertHasErrors(['name']);

        Livewire::test(RoleEdit::class, ['role' => $this->roleToEdit])
            ->set('name', 'another_role_name') // Name must be unique
            ->call('updateRole')
            ->assertHasErrors(['name' => 'unique']);
    }
}
