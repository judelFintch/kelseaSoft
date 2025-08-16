<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_roles_can_be_associated_with_a_permission()
    {
        $permission = Permission::factory()->create(['name' => 'edit articles']);
        $roleEditor = Role::factory()->create(['name' => 'editor']);
        $roleAdmin = Role::factory()->create(['name' => 'admin']);

        $permission->roles()->attach($roleEditor);
        $permission->roles()->attach($roleAdmin);

        $this->assertTrue($permission->roles->contains($roleEditor));
        $this->assertTrue($permission->roles->contains($roleAdmin));
        $this->assertCount(2, $permission->roles);

        // Also test the inverse: role has permission
        $this->assertTrue($roleEditor->permissions->contains($permission));
    }
}
