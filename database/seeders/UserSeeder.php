<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a 'root' role
        $rootRole = Role::firstOrCreate([
            'name' => 'root',
            'display_name' => 'Root Administrator',
            'description' => 'User with all permissions'
        ]);

        // Define all permissions (mirroring the ones in routes/web.php for now)
        // In a real application, you might have a more robust way to manage this list
        // or fetch them directly if they are already seeded by another seeder.
        $permissions = [
            'view company',
            'create company',
            'edit company',
            'delete company',
            'view user',
            'create user',
            'edit user',
            'delete user',
            // Permissions for user and role management
            'manage users',
            'manage roles',
            'manage permissions',
            // Add any other permissions defined in your application
        ];

        $permissionIds = [];
        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate([
                'name' => $permissionName,
                'display_name' => ucwords(str_replace('_', ' ', $permissionName)),
                'description' => ucwords(str_replace('_', ' ', $permissionName))
            ]);
            $permissionIds[] = $permission->id;
        }

        // Assign all permissions to the 'root' role
        // Use syncWithoutDetaching to avoid duplicate entries if seeder is run multiple times
        $rootRole->permissions()->syncWithoutDetaching($permissionIds);

        // Create a 'root' user
        $rootUser = User::firstOrCreate(
            ['email' => 'root@example.com'],
            [
                'name' => 'Root User',
                'password' => Hash::make('password'), // Change this in a real application!
            ]
        );

        // Assign the 'root' role to the 'root' user
        // Use syncWithoutDetaching to avoid duplicate entries
        $rootUser->roles()->syncWithoutDetaching([$rootRole->id]);

        // Create a regular admin user as in the original seeder for general use
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );
        // Optionally, assign some default role to the admin user if needed
        // For example, if you create an 'admin' role with a subset of permissions:
        // $adminRole = Role::firstOrCreate(['name' => 'admin', ...]);
        // $adminUser->roles()->syncWithoutDetaching([$adminRole->id]);
    }
}
