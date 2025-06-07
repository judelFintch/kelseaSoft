<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // Added for logging

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define and Create Roles
        $roleDefinitions = [
            ['name' => 'root', 'display_name' => 'Root', 'description' => 'Super Administrator with all permissions'],
            ['name' => 'admin', 'display_name' => 'Admin', 'description' => 'Administrator with most permissions'],
            ['name' => 'editor', 'display_name' => 'Editor', 'description' => 'User who can create and edit content'],
            ['name' => 'viewer', 'display_name' => 'Viewer', 'description' => 'User who can only view content'],
        ];
        foreach ($roleDefinitions as $roleDef) {
            Role::firstOrCreate(['name' => $roleDef['name']], $roleDef);
        }

        // Define and Create Permissions
        $permissionNames = [
            // RBAC Management
            'manage users',
            'manage roles',
            'manage permissions',
            // Company Management
            'view company',
            'create company',
            'edit company',
            'delete company',
            // Folder Management
            'view folder',
            'create folder',
            'edit folder',
            'delete folder',
            // Licence Management
            'view licence',
            'create licence',
            'edit licence',
            'delete licence',
            // Invoice Management
            'generate invoice',
            'view invoice',
            'edit invoice',
            'download invoice',
            'view global_invoice',
            'download global_invoice',
            // Settings & Financials
            'manage taxes',
            'manage extra_fees',
            'manage agency_fees',
            'manage currencies',
            // Other common permissions
            'view dashboard',
            'manage settings',
            'view reports',
            'upload files',
            'manage bivac',
            'manage file_types',
            'manage transporters',
            'manage suppliers',
            'manage locations',
            'manage customs_offices',
            'manage declaration_types',
            'manage merchandise_types',
            'manage customs_regimes',
        ];

        foreach ($permissionNames as $permissionName) {
            $displayName = ucwords(str_replace('_', ' ', $permissionName));
            Permission::firstOrCreate(
                ['name' => $permissionName],
                ['display_name' => $displayName, 'description' => "Permission to " . $displayName]
            );
        }

        // --- Retrieve Roles and Permissions ---
        $allPermissions = Permission::pluck('id', 'name'); // Fetches as 'name' => 'id'

        $rootRole = Role::where('name', 'root')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $editorRole = Role::where('name', 'editor')->first();
        $viewerRole = Role::where('name', 'viewer')->first();

        // --- Assign Permissions to Roles ---

        // Root Role: Assign all permissions
        if ($rootRole) {
            $rootRole->permissions()->sync($allPermissions->values()->all());
        } else {
            Log::warning("UserSeeder: Root role not found, cannot assign permissions.");
        }

        // Admin Role Permissions
        if ($adminRole) {
            $adminPermissionNames = [
                'manage users',
                'manage roles',
                'manage permissions', // Full RBAC control
                'view company',
                'create company',
                'edit company',
                'delete company', // Full Company control
                'view folder',
                'create folder',
                'edit folder',
                'delete folder', // Full Folder control
                'view licence',
                'create licence',
                'edit licence',
                'delete licence', // Full Licence control
                'generate invoice',
                'view invoice',
                'edit invoice',
                'download invoice', // Full Invoice control
                'view global_invoice',
                'download global_invoice',
                'manage taxes',
                'manage extra_fees',
                'manage agency_fees',
                'manage currencies', // Full Financials
                'view dashboard',
                'manage settings',
                'view reports',
                'upload files',
                'manage bivac',
                'manage file_types',
                'manage transporters',
                'manage suppliers',
                'manage locations',
                'manage customs_offices',
                'manage declaration_types',
                'manage merchandise_types',
                'manage customs_regimes',
            ];
            $adminPermissionIds = $allPermissions->only($adminPermissionNames)->values()->all();
            $adminRole->permissions()->sync($adminPermissionIds);
        } else {
            Log::warning("UserSeeder: Admin role not found, cannot assign permissions.");
        }

        // Editor Role Permissions
        if ($editorRole) {
            $editorPermissionNames = [
                'view company',
                'create company',
                'edit company',
                'view folder',
                'create folder',
                'edit folder',
                'view licence',
                'create licence',
                'edit licence',
                'generate invoice',
                'view invoice',
                'edit invoice',
                'download invoice',
                'upload files',
                'view dashboard',
            ];
            $editorPermissionIds = $allPermissions->only($editorPermissionNames)->values()->all();
            $editorRole->permissions()->sync($editorPermissionIds);
        } else {
            Log::warning("UserSeeder: Editor role not found, cannot assign permissions.");
        }

        // Viewer Role Permissions
        if ($viewerRole) {
            $viewerPermissionNames = [
                'view company',
                'view folder',
                'view licence',
                'view invoice',
                'view global_invoice',
                'download invoice',
                'download global_invoice',
                'view reports',
                'view dashboard',
            ];
            $viewerPermissionIds = $allPermissions->only($viewerPermissionNames)->values()->all();
            $viewerRole->permissions()->sync($viewerPermissionIds);
        } else {
            Log::warning("UserSeeder: Viewer role not found, cannot assign permissions.");
        }

        // --- Create Sample Users and Assign Roles ---
        if ($rootRole) {
            User::firstOrCreate(['email' => 'root@example.com'], ['name' => 'Root User', 'password' => Hash::make('password')])
                ->roles()->sync([$rootRole->id]);
        }
        if ($adminRole) {
            User::firstOrCreate(['email' => 'admin@example.com'], ['name' => 'Admin User', 'password' => Hash::make('password')])
                ->roles()->sync([$adminRole->id]);
        }
        if ($editorRole) {
            User::firstOrCreate(['email' => 'editor@example.com'], ['name' => 'Editor User', 'password' => Hash::make('password')])
                ->roles()->sync([$editorRole->id]);
        }
        if ($viewerRole) {
            User::firstOrCreate(['email' => 'viewer@example.com'], ['name' => 'Viewer User', 'password' => Hash::make('password')])
                ->roles()->sync([$viewerRole->id]);
        }
    }
}
