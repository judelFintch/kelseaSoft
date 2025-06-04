<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckPermission;

class CheckPermissionMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Define a test route protected by the middleware
        Route::get('/test-permission-route', function () {
            return response('Success', 200);
        })->middleware(['web', 'auth', 'permission:access test route']);

        // Define a permission for testing
        Permission::firstOrCreate(['name' => 'access test route', 'display_name' => 'Access Test Route']);
    }

    public function test_guest_user_is_redirected_to_login()
    {
        $response = $this->get('/test-permission-route');
        $response->assertRedirect(route('login'));
    }

    public function test_user_with_permission_can_access_route()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create(['name' => 'tester']);
        $permission = Permission::where('name', 'access test route')->first();

        $role->permissions()->attach($permission);
        $user->roles()->attach($role);

        $response = $this->actingAs($user)->get('/test-permission-route');
        $response->assertStatus(200);
        $response->assertSee('Success');
    }

    public function test_user_without_permission_is_blocked()
    {
        $user = User::factory()->create(); // User has no roles/permissions by default

        $response = $this->actingAs($user)->get('/test-permission-route');
        $response->assertStatus(403);
    }

    public function test_user_with_other_permissions_but_not_the_required_one_is_blocked()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create(['name' => 'other_role']);
        $otherPermission = Permission::factory()->create(['name' => 'other permission']);

        $role->permissions()->attach($otherPermission);
        $user->roles()->attach($role);

        $response = $this->actingAs($user)->get('/test-permission-route');
        $response->assertStatus(403);
    }
}
