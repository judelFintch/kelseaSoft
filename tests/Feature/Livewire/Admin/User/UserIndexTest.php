<?php

namespace Tests\Feature\Livewire\Admin\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Livewire\Livewire;
use App\Livewire\Admin\User\UserIndex;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate; // Import Gate

class UserIndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed the database with all necessary roles and permissions
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);
    }

    protected function getAndPrepareRootUser(): User
    {
        $rootUser = User::where('email', 'root@example.com')->firstOrFail();

        // Crucial: Ensure Gate is fresh and knows about this user's permissions for the test
        Gate::flush(); // Clear any cached gates
        // Define permissions again or ensure AuthServiceProvider is booted
        // For simplicity in this last attempt, we'll rely on the User's hasPermissionTo
        // method which should work if roles/permissions are correctly in DB.
        // The issue might be Gate caching or when it's resolved in Livewire tests.

        // Minimal re-definition for testing Gate interaction
        $permissions = ['manage users', 'create user', 'edit user', 'delete user'];
        foreach($permissions as $pName) {
            Permission::firstOrCreate(['name' => $pName], ['display_name' => ucfirst($pName)]);
            // This explicit define might be needed if the AuthServiceProvider's Gate definitions aren't sticking
            Gate::define($pName, function (User $user) use ($pName) {
                return $user->hasPermissionTo($pName);
            });
        }
        // Re-attach roles/permissions explicitly for the user if needed,
        // though seeder should handle this for root.
        // $rootRole = Role::where('name', 'root')->firstOrFail();
        // $rootUser->roles()->syncWithoutDetaching([$rootRole->id]);


        return $rootUser->fresh(); // refresh relations
    }


    public function test_user_index_renders_successfully_for_authorized_user()
    {
        $adminUser = $this->getAndPrepareRootUser();

        Livewire::actingAs($adminUser)
            ->test(UserIndex::class)
            ->assertStatus(200) // This is the key assertion failing with 403
            ->assertViewIs('livewire.admin.user.user-index')
            ->assertSee('Users');
    }

    public function test_user_index_is_protected_for_unauthorized_user()
    {
        $unauthorizedUser = User::factory()->create(); // A user without the 'root' role or 'manage users' permission
        Livewire::actingAs($unauthorizedUser)
            ->test(UserIndex::class)
            ->assertStatus(403);
    }

    public function test_user_index_displays_users()
    {
        $adminUser = $this->getAndPrepareRootUser();
        User::factory()->create(['name' => 'Test User One', 'email' => 'one@example.com']);
        User::factory()->create(['name' => 'Test User Two', 'email' => 'two@example.com']);

        Livewire::actingAs($adminUser)
            ->test(UserIndex::class)
            ->assertStatus(200) // Check again to ensure page loads before asserting content
            ->assertSee('Test User One')
            ->assertSee('one@example.com')
            ->assertSee('Test User Two')
            ->assertSee('two@example.com');
    }

    public function test_user_index_search_filters_users()
    {
        $adminUser = $this->getAndPrepareRootUser();
        User::factory()->create(['name' => 'Alice Smith', 'email' => 'alice@example.com']);
        User::factory()->create(['name' => 'Bob Johnson', 'email' => 'bob@example.com']);

        Livewire::actingAs($adminUser)
            ->test(UserIndex::class)
            ->set('search', 'Alice')
            ->assertStatus(200)
            ->assertSee('Alice Smith')
            ->assertDontSee('Bob Johnson');
    }

    public function test_can_delete_user_from_index()
    {
        $adminUser = $this->getAndPrepareRootUser();
        $userToDelete = User::factory()->create();

        Livewire::actingAs($adminUser)
            ->test(UserIndex::class)
            ->call('deleteUser', $userToDelete->id)
            ->assertEmitted('message')
            ->assertDontSee($userToDelete->name);

        // Assuming soft deletes are not used for users or this is a force delete
        // If soft deletes are used, you might need to check for is_deleted or similar
        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }
}
