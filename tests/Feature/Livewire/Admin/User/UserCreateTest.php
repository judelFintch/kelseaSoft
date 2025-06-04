<?php

namespace Tests\Feature\Livewire\Admin\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Livewire\Livewire;
use App\Livewire\Admin\User\UserCreate;
use Illuminate\Support\Facades\Artisan;

class UserCreateTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);
        $this->adminUser = User::where('email', 'root@example.com')->first(); // Use seeded root user
    }

    public function test_user_create_renders_successfully_for_authorized_user()
    {
        $this->actingAs($this->adminUser);
        Livewire::test(UserCreate::class)
            ->assertStatus(200)
            ->assertViewIs('livewire.admin.user.user-create')
            ->assertSee('Create User');
    }

    public function test_user_create_is_protected_for_unauthorized_user()
    {
        $unauthorizedUser = User::factory()->create();
        $this->actingAs($unauthorizedUser);

        Livewire::test(UserCreate::class)
            ->assertStatus(403);
    }

    public function test_can_create_user_without_roles()
    {
        $this->actingAs($this->adminUser);

        Livewire::test(UserCreate::class)
            ->set('name', 'New User')
            ->set('email', 'newuser@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('createUser')
            ->assertRedirect(route('admin.user.index')); // Assuming redirect

        $this->assertDatabaseHas('users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
        ]);
        $newUser = User::where('email', 'newuser@example.com')->first();
        $this->assertTrue($newUser->roles->isEmpty());
    }

    public function test_can_create_user_with_roles()
    {
        $this->actingAs($this->adminUser);
        $role1 = Role::factory()->create(['name' => 'editor']);
        $role2 = Role::factory()->create(['name' => 'viewer']);

        Livewire::test(UserCreate::class)
            ->set('name', 'Role User')
            ->set('email', 'roleuser@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->set('selectedRoles', [$role1->id, $role2->id])
            ->call('createUser')
            ->assertRedirect(route('admin.user.index'));

        $this->assertDatabaseHas('users', ['email' => 'roleuser@example.com']);
        $newUser = User::where('email', 'roleuser@example.com')->first();
        $this->assertCount(2, $newUser->roles);
        $this->assertTrue($newUser->roles->contains($role1));
        $this->assertTrue($newUser->roles->contains($role2));
    }

    public function test_user_creation_validation_errors()
    {
        $this->actingAs($this->adminUser);

        Livewire::test(UserCreate::class)
            ->set('name', '') // Name is required
            ->set('email', 'notanemail') // Email must be valid
            ->set('password', 'short') // Password too short
            ->set('password_confirmation', 'mismatch') // Passwords don't match
            ->call('createUser')
            ->assertHasErrors(['name', 'email', 'password']);
    }
}
