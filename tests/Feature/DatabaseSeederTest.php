<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_runs_without_errors_and_creates_root_user_with_role_and_permissions()
    {
        // Run the DatabaseSeeder
        // Using --class option to specifically call DatabaseSeeder and its dependencies
        // Using --force to run in production if needed, though RefreshDatabase handles environment
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);

        // Test that the root user is created
        $rootUser = User::where('email', 'root@example.com')->first();
        $this->assertNotNull($rootUser, "Root user was not created.");

        // Test that the 'root' role exists and is assigned to the root user
        $rootRole = Role::where('name', 'root')->first();
        $this->assertNotNull($rootRole, "'root' role was not created.");
        $this->assertTrue($rootUser->roles->contains($rootRole), "Root user does not have the 'root' role.");

        // Test that the 'root' role has all defined permissions
        // This requires knowing all permissions that should be defined by UserSeeder
        $definedPermissions = [
            'view company', 'create company', 'edit company', 'delete company',
            'view user', 'create user', 'edit user', 'delete user',
            'manage users', 'manage roles', 'manage permissions',
            // Add any other permissions that UserSeeder is expected to create
        ];
        $allPermissions = Permission::whereIn('name', $definedPermissions)->get();

        $this->assertEquals(
            count($definedPermissions),
            $allPermissions->count(),
            "Not all expected permissions were found in the database."
        );

        foreach ($allPermissions as $permission) {
            $this->assertTrue(
                $rootRole->permissions->contains($permission),
                "Root role is missing permission: {$permission->name}"
            );
        }

        $this->assertEquals(
            $allPermissions->count(),
            $rootRole->permissions->count(),
            "Root role has an incorrect number of permissions."
        );

        // Check admin user as well
        $adminUser = User::where('email', 'admin@example.com')->first();
        $this->assertNotNull($adminUser, "Admin user was not created.");
    }

    public function test_seeders_are_idempotent()
    {
        // Call seeders first time
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);
        $userCount1 = User::count();
        $roleCount1 = Role::count();
        $permissionCount1 = Permission::count();
        $roleUserCount1 = DB::table('role_user')->count();
        $permissionRoleCount1 = DB::table('permission_role')->count();

        // Call seeders second time
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);
        $userCount2 = User::count();
        $roleCount2 = Role::count();
        $permissionCount2 = Permission::count();
        $roleUserCount2 = DB::table('role_user')->count();
        $permissionRoleCount2 = DB::table('permission_role')->count();

        $this->assertEquals($userCount1, $userCount2, "User count changed on second seed.");
        $this->assertEquals($roleCount1, $roleCount2, "Role count changed on second seed.");
        $this->assertEquals($permissionCount1, $permissionCount2, "Permission count changed on second seed.");
        $this->assertEquals($roleUserCount1, $roleUserCount2, "Role-User pivot table count changed on second seed.");
        $this->assertEquals($permissionRoleCount1, $permissionRoleCount2, "Permission-Role pivot table count changed on second seed.");
    }
}
