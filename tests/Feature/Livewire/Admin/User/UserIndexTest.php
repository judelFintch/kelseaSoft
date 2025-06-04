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

class UserIndexTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);

        // Use the seeded root user which should have all permissions
        $this->adminUser = User::where('email', 'root@example.com')->first();
    }

    public function test_user_index_renders_successfully_for_authorized_user()
    {
        $this->actingAs($this->adminUser);
        Livewire::test(UserIndex::class)
            ->assertStatus(200)
            ->assertViewIs('livewire.admin.user.user-index')
            ->assertSee('Users');
    }

    public function test_user_index_is_protected_for_unauthorized_user()
    {
        $unauthorizedUser = User::factory()->create();
        $this->actingAs($unauthorizedUser);

        Livewire::test(UserIndex::class)
            ->assertStatus(403); // Or use assertForbidden() if preferred
    }

    public function test_user_index_displays_users()
    {
        $this->actingAs($this->adminUser);
        User::factory()->create(['name' => 'Test User One', 'email' => 'one@example.com']);
        User::factory()->create(['name' => 'Test User Two', 'email' => 'two@example.com']);

        Livewire::test(UserIndex::class)
            ->assertSee('Test User One')
            ->assertSee('one@example.com')
            ->assertSee('Test User Two')
            ->assertSee('two@example.com');
    }

    public function test_user_index_search_filters_users()
    {
        $this->actingAs($this->adminUser);
        User::factory()->create(['name' => 'Alice Smith', 'email' => 'alice@example.com']);
        User::factory()->create(['name' => 'Bob Johnson', 'email' => 'bob@example.com']);

        Livewire::test(UserIndex::class)
            ->set('search', 'Alice')
            ->assertSee('Alice Smith')
            ->assertDontSee('Bob Johnson');
    }

    public function test_can_delete_user_from_index()
    {
        $this->actingAs($this->adminUser);
        $userToDelete = User::factory()->create();

        Livewire::test(UserIndex::class)
            ->call('deleteUser', $userToDelete->id)
            ->assertEmitted('message') // Assuming a flash message is emitted
            ->assertDontSee($userToDelete->name);

        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }
}
