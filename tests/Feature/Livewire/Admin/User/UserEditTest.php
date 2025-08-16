<?php

namespace Tests\Feature\Livewire\Admin\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Livewire\Livewire;
use App\Livewire\Admin\User\UserEdit;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class UserEditTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $userToEdit;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);
        $this->adminUser = User::where('email', 'root@example.com')->first(); // Use seeded root user
        $this->userToEdit = User::factory()->create(); // Create a user to be edited
    }

    public function test_user_edit_renders_successfully_for_authorized_user()
    {
        $this->actingAs($this->adminUser);
        Livewire::test(UserEdit::class, ['user' => $this->userToEdit])
            ->assertStatus(200)
            ->assertViewIs('livewire.admin.user.user-edit')
            ->assertSee('Edit User: '. $this->userToEdit->name)
            ->assertSet('name', $this->userToEdit->name)
            ->assertSet('email', $this->userToEdit->email);
    }

    public function test_user_edit_is_protected_for_unauthorized_user()
    {
        $unauthorizedUser = User::factory()->create();
        $this->actingAs($unauthorizedUser);

        Livewire::test(UserEdit::class, ['user' => $this->userToEdit])
            ->assertStatus(403);
    }

    public function test_can_update_user_details_without_changing_password_or_roles()
    {
        $this->actingAs($this->adminUser);

        Livewire::test(UserEdit::class, ['user' => $this->userToEdit])
            ->set('name', 'Updated Name')
            ->set('email', 'updated@example.com')
            ->call('updateUser')
            ->assertRedirect(route('admin.user.index'));

        $this->userToEdit->refresh();
        $this->assertEquals('Updated Name', $this->userToEdit->name);
        $this->assertEquals('updated@example.com', $this->userToEdit->email);
    }

    public function test_can_update_user_password()
    {
        $this->actingAs($this->adminUser);

        Livewire::test(UserEdit::class, ['user' => $this->userToEdit])
            ->set('password', 'newSecurePassword123')
            ->set('password_confirmation', 'newSecurePassword123')
            ->call('updateUser');

        $this->userToEdit->refresh();
        $this->assertTrue(Hash::check('newSecurePassword123', $this->userToEdit->password));
    }

    public function test_can_update_user_roles()
    {
        $this->actingAs($this->adminUser);
        $role1 = Role::factory()->create(['name' => 'role1']);
        $role2 = Role::factory()->create(['name' => 'role2']);
        $this->userToEdit->roles()->attach(Role::factory()->create(['name' => 'initial_role']));


        Livewire::test(UserEdit::class, ['user' => $this->userToEdit])
            ->set('selectedRoles', [$role1->id, $role2->id])
            ->call('updateUser');

        $this->userToEdit->refresh();
        $this->assertCount(2, $this->userToEdit->roles);
        $this->assertTrue($this->userToEdit->roles->contains($role1));
        $this->assertTrue($this->userToEdit->roles->contains($role2));
        $this->assertFalse($this->userToEdit->roles->contains(Role::where('name', 'initial_role')->first()));
    }

    public function test_user_update_validation_errors()
    {
        $this->actingAs($this->adminUser);

        Livewire::test(UserEdit::class, ['user' => $this->userToEdit])
            ->set('name', '') // Name is required
            ->set('email', 'notanemail') // Email must be valid
            ->set('password', 'short') // Password too short if provided
            ->set('password_confirmation', 'mismatch') // Passwords don't match if password provided
            ->call('updateUser')
            ->assertHasErrors(['name', 'email', 'password']);
    }
}
