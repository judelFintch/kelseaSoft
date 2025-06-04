<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_assigned_a_role_and_roles_can_be_retrieved()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create(['name' => 'editor', 'display_name' => 'Editor']);

        $user->roles()->attach($role);

        $this->assertTrue($user->roles->contains($role));
        $this->assertEquals('editor', $user->roles->first()->name);
    }

    public function test_has_permission_to_method()
    {
        $user = User::factory()->create();
        $roleEditor = Role::factory()->create(['name' => 'editor', 'display_name' => 'Editor']);
        $roleViewer = Role::factory()->create(['name' => 'viewer', 'display_name' => 'Viewer']);

        $permissionEditArticles = Permission::factory()->create(['name' => 'edit articles']);
        $permissionViewArticles = Permission::factory()->create(['name' => 'view articles']);
        $permissionDeleteArticles = Permission::factory()->create(['name' => 'delete articles']);

        // Assign permissions to roles
        $roleEditor->permissions()->attach($permissionEditArticles);
        $roleEditor->permissions()->attach($permissionViewArticles);
        $roleViewer->permissions()->attach($permissionViewArticles);

        // Assign roles to user
        $user->roles()->attach($roleEditor);
        $user->roles()->attach($roleViewer);

        // Test direct permission through a role
        $this->assertTrue($user->hasPermissionTo('edit articles'));
        $this->assertTrue($user->hasPermissionTo('view articles'));

        // Test user does not have a specific permission
        $this->assertFalse($user->hasPermissionTo('delete articles'));

        // Test with a non-existent permission
        $this->assertFalse($user->hasPermissionTo('non_existent_permission'));

        // Test with a user having no roles
        $userWithoutRoles = User::factory()->create();
        $this->assertFalse($userWithoutRoles->hasPermissionTo('view articles'));
    }

    public function test_has_permission_to_with_multiple_roles_and_permissions()
    {
        $user = User::factory()->create();
        $roleManager = Role::factory()->create(['name' => 'manager']);
        $roleContributor = Role::factory()->create(['name' => 'contributor']);

        $permManageUsers = Permission::factory()->create(['name' => 'manage users']);
        $permCreatePosts = Permission::factory()->create(['name' => 'create posts']);
        $permEditOwnPosts = Permission::factory()->create(['name' => 'edit own posts']);
        $permPublishPosts = Permission::factory()->create(['name' => 'publish posts']);

        $roleManager->permissions()->sync([$permManageUsers->id, $permPublishPosts->id, $permCreatePosts->id]);
        $roleContributor->permissions()->sync([$permCreatePosts->id, $permEditOwnPosts->id]);

        $user->roles()->sync([$roleManager->id, $roleContributor->id]);

        $this->assertTrue($user->hasPermissionTo('manage users'));
        $this->assertTrue($user->hasPermissionTo('publish posts'));
        $this->assertTrue($user->hasPermissionTo('create posts')); // Has from both, should be true
        $this->assertTrue($user->hasPermissionTo('edit own posts'));
        $this->assertFalse($user->hasPermissionTo('delete posts'));
    }
}
