<?php

use Illuminate\Support\Facades\Auth;

it('user can register', function () {
    $response = $this->post('/register', [
        'name' => 'John Doe',
        'email' => 'email@testmail.com',
        'password' => 'password',
    ]);

    $response->assertRedirect('/');

    $this->assertAuthenticated();

    expect(Auth::user())->toMatchArray([
        'name' => 'John Doe',
        'email' => 'email@testmail.com'
    ]);
});