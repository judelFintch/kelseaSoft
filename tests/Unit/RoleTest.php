<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_role_can_be_assigned_permissions_and_permissions_can_be_retrieved()
    {
        $role = Role::factory()->create(['name' => 'admin']);
        $permissionManageSettings = Permission::factory()->create(['name' => 'manage settings']);
        $permissionViewDashboard = Permission::factory()->create(['name' => 'view dashboard']);

        $role->permissions()->attach($permissionManageSettings);
        $role->permissions()->attach($permissionViewDashboard);

        $this->assertTrue($role->permissions->contains($permissionManageSettings));
        $this->assertTrue($role->permissions->contains($permissionViewDashboard));
        $this->assertCount(2, $role->permissions);
    }

    public function test_users_can_be_assigned_to_a_role()
    {
        $role = Role::factory()->create(['name' => 'subscriber']);
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $role->users()->attach($user1);
        $role->users()->attach($user2);

        $this->assertTrue($role->users->contains($user1));
        $this->assertTrue($role->users->contains($user2));
        $this->assertCount(2, $role->users);

        // Also test the inverse: user has role
        $this->assertTrue($user1->roles->contains($role));
    }
}
