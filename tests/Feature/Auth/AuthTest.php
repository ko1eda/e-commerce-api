<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class AuthTest extends TestCase
{
    public function test_a_user_with_incorrect_credentials_cannot_login()
    {
        // Given we have a request to our endpoint from a user
        // whose email is not in the system, then they cannot log in
        $this->json('POST', route('login'), [
            'email' => 'joe@cool.com',
            'password' => 'aaaa'
        ])->assertStatus(422);
    }


    public function test_a_user_with_correct_credentials_recieves_a_token()
    {
        // Given we have a request to our endpoint from a user
        // note: save the non-hashed password 
        $user = factory(User::class)->create([
            'password' => $pass = 'cats'
        ]);

        // if that user attempts to login weith their information
        // then they are awarded a token
        $this->json('POST', route('login'), [
            'email' => $user->email,
            'password' => $pass
        ])->assertJsonStructure([
            'meta' => [
                'token'
            ]
        ]);
    }

    public function test_it_returns_the_users_information_on_login()
    {
        // Given we have a request to our endpoint from a user
        // note: save the non-hashed password
        $user = factory(User::class)->create([
            'password' => $pass = 'cats'
        ]);

        // if that user attempts to login weith their information
        // then the correct data is returned
        $this->json('POST', route('login'), [
            'email' => $user->email,
            'password' => $pass
        ])->assertJsonFragment([
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'currency' => $user->currency,
            'locale' => $user->locale
        ]);
    }

    public function test_only_an_authenticated_user_can_access_the_me_route()
    {
        // given we have a  user
        $user = factory(User::class)->create();

        // and they are not authenticated
        // then if they try and access the me route
        // they will recieve a 401 unauthorized
        $this->withExceptionHandling()->json('GET', route('me'))
            ->assertStatus(401);

        // however if they do authenticate and provide a bearer token
        // then they should recieve their private user information
        // as a json response
        $this->jsonAs($user, 'GET', route('me'))
            ->assertJsonFragment(['id' => $user->id]);
    }
}
