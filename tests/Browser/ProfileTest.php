<?php

use App\Models\User;
use App\Notifications\EmailChanged;
use Illuminate\Support\Facades\Notification as FacadesNotification;

it('requires authentication', function () {
    visit(route('profile.edit'))->assertPathIs('/login');

});

it('edits a profile', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit(route('profile.edit'))
        ->assertValue('name', $user->name)
        ->fill('name', 'New Name')
        ->click('Update Account')
        ->assertSee('Profile updated successfully.');

    expect($user->fresh())->toMatchArray([
        'name' => 'New Name',
    ]);

});

