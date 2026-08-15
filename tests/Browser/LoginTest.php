<?php

use App\Models\User;


it('logs in a user with correct credentials', function () {
    $user = User::factory()->create(['password' => 'password']);
    $this->actingAs($user);
    $this->assertAuthenticated();
});

it('log out a user', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $this->assertAuthenticated();

    visit('/')
        ->click('Log Out');

    $this->assertGuest();
});
