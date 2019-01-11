<?php

namespace Tests\Feature\Categories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class RegistrationTest extends TestCase
{
    public function test_it_requires_a_name()
    {
        $this->withExceptionHandling()
            ->json('POST', route('register'))
            ->assertJsonValidationErrors(['name']);
    }

    public function test_it_requires_an_email()
    {
        $this->withExceptionHandling()
            ->json('POST', route('register'))
            ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_password()
    {
        $this->withExceptionHandling()
            ->json('POST', route('register'))
            ->assertJsonValidationErrors(['password']);
    }


    public function test_it_registers_a_new_user()
    {
        // Given we have no users
        $this->assertCount(0, User::all());

        // if a user registers to our site
        $this->json('POST', route('register'), [
            'name' => 'User',
            'email' => 'email@email.com',
            'password' => 'secret'
        ]);

        // our db now contains the 1 newly registered user
        $this->assertCount(1, User::all());
    }

    public function test_it_returns_a_new_user()
    {
        // given we have a user
        $user = factory(User::class)->make();

        // and that user registers an account
        $user = $user->makeVisible('password')->toArray();

        // then we should get the returned newly created user
        $this->json('POST', route('register'), $user)
            ->assertJsonFragment([
                'email' => $user['email'],
                'name' => $user['name'],
                'locale' => $user['locale']
            ]);
    }
}
