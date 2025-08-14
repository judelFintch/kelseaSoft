<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class DownloadAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Route::get('/test-download-route', function () {
            return response('Downloaded', 200);
        })->middleware(['web', 'auth', 'download.auth']);

        Permission::firstOrCreate([
            'name' => 'download files',
            'display_name' => 'Download Files',
        ]);
    }

    public function test_guest_user_is_redirected_to_login(): void
    {
        $response = $this->get('/test-download-route');
        $response->assertRedirect(route('login'));
    }

    public function test_user_with_permission_can_access_route(): void
    {
        $user = User::factory()->create();
        $role = Role::factory()->create(['name' => 'downloader']);
        $permission = Permission::where('name', 'download files')->first();

        $role->permissions()->attach($permission);
        $user->roles()->attach($role);

        $response = $this->actingAs($user)->get('/test-download-route');
        $response->assertStatus(200);
        $response->assertSee('Downloaded');
    }

    public function test_user_without_permission_is_blocked(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/test-download-route');
        $response->assertStatus(403);
    }
}
