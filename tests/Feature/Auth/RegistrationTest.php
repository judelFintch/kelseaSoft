<?php

test('guests cannot access the registration screen', function () {
    $response = $this->get('/register');

    $response->assertRedirect('/login');
});

test('authenticated users can register new users', function () {
    $admin = App\Models\User::factory()->create();

    $response = $this->actingAs($admin)->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});
