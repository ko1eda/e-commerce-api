<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Contracts\JWTSubject;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    /**
     * Get jwt token for the given user (using the JWT guard tokenByID method)
     * Attatch it to the request header as a bearer token
     * then return the response to the request
     *
     * @param JWTSubject $user
     * @param String $method
     * @param String $endpoint
     * @param mixed array
     * @param mixed array
     * @return void
     */
    public function jsonAs(JWTSubject $user, String $method, String $endpoint, array $data = [], array $headers = [])
    {
        $token = auth()->tokenById($user->id);

        return $this->json($method, $endpoint, $data, array_merge($headers, [
            'Authorization' => 'Bearer ' . $token
        ]));
    }
}
