<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    // Create the User role that will be assigned during registration
    \Spatie\Permission\Models\Role::findOrCreate('User');
    
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});
