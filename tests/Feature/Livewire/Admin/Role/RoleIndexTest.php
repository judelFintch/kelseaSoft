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

    protected function seedDatabase()
    {
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);
    }

    protected function getRootUser(): User
    {
        $rootUser = User::where('email', 'root@example.com')->first();
        if (!$rootUser) {
            $rootUser = User::factory()->create(['email' => 'root@example.com']);
            $rootRole = Role::firstOrCreate(['name' => 'root'], ['display_name' => 'Root']);
            $permissions = Permission::all();
            if ($permissions->isEmpty()) {
                 $this->seedPermissions();
                 $permissions = Permission::all();
            }
            $rootRole->permissions()->sync($permissions->pluck('id'));
            $rootUser->roles()->attach($rootRole);
        }
        $rootRole = Role::where('name', 'root')->first();
        if ($rootRole && !$rootUser->roles->contains($rootRole)) {
            $rootUser->roles()->syncWithoutDetaching([$rootRole->id]);
        }
        return $rootUser->fresh();
    }

    private function seedPermissions()
    {
        $permissions = [
            'manage users', 'create user', 'edit user', 'delete user',
            'manage roles', 'create role', 'edit role', 'delete role',
            'manage permissions',
            'view company', 'create company', 'edit company', 'delete company',
        ];
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName], ['display_name' => ucwords(str_replace('_', ' ', $permissionName))]);
        }
    }

    public function test_role_index_renders_successfully_for_authorized_user()
    {
        $this->seedDatabase();
        $adminUser = $this->getRootUser();

        Livewire::actingAs($adminUser)
            ->test(RoleIndex::class)
            ->assertStatus(200)
            ->assertViewIs('livewire.admin.role.role-index')
            ->assertSee('Roles');
    }

    public function test_role_index_is_protected_for_unauthorized_user()
    {
        $unauthorizedUser = User::factory()->create();
        Livewire::actingAs($unauthorizedUser)
            ->test(RoleIndex::class)
            ->assertStatus(403);
    }

    public function test_role_index_displays_roles()
    {
        $this->seedDatabase();
        $adminUser = $this->getRootUser();

        Role::factory()->create(['name' => 'editor-role-test', 'display_name' => 'Editor Role Test']); // Ensure unique name
        Role::factory()->create(['name' => 'viewer-role-test', 'display_name' => 'Viewer Role Test']);

        Livewire::actingAs($adminUser)
            ->test(RoleIndex::class)
            ->assertSee('Editor Role Test')
            ->assertSee('Viewer Role Test');
    }

    public function test_role_index_search_filters_roles()
    {
        $this->seedDatabase();
        $adminUser = $this->getRootUser();

        Role::factory()->create(['name' => 'alpha_role_search', 'display_name' => 'Alpha Search']);
        Role::factory()->create(['name' => 'beta_role_search', 'display_name' => 'Beta Search']);

        Livewire::actingAs($adminUser)
            ->test(RoleIndex::class)
            ->set('search', 'Alpha Search')
            ->assertSee('alpha_role_search')
            ->assertDontSee('beta_role_search');
    }

    public function test_can_delete_role_from_index()
    {
        $this->seedDatabase();
        $adminUser = $this->getRootUser();
        $roleToDelete = Role::factory()->create(['name' => 'temporary_role_to_delete']);

        Livewire::actingAs($adminUser)
            ->test(RoleIndex::class)
            ->call('deleteRole', $roleToDelete->id)
            ->assertEmitted('message')
            ->assertDontSee($roleToDelete->name);

        $this->assertDatabaseMissing('roles', ['id' => $roleToDelete->id]);
    }

    public function test_cannot_delete_root_role()
    {
        $this->seedDatabase();
        $adminUser = $this->getRootUser();
        $rootRole = Role::where('name', 'root')->firstOrFail();

        Livewire::actingAs($adminUser)
            ->test(RoleIndex::class)
            ->call('deleteRole', $rootRole->id)
            ->assertEmitted('error')
            ->assertSee($rootRole->name);

        $this->assertDatabaseHas('roles', ['id' => $rootRole->id]);
    }
}
