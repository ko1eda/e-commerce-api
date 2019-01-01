<?php

namespace Tests\Feature\Middleware;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Middleware\ProfileJsonResponse;

class ProfileJsonResponseTest extends TestCase
{

    public function test_it_appends_debugbar_information_to_the_request_if_debug_parameter_is_set()
    {
        // enable debug bar for test
        app('debugbar')->enable();

        // Given we have a request without debug in the input
        // Then our middleware should not return any debug info
        $this->json('GET', route('products.index'))
            ->assertJsonMissing(['_debugbar' => [] ]);

        // However if we then add debug to the routes input parameters
        // Then we should get debug information
        $this->json('GET', route('products.index') . '?_debug')
            ->assertJsonStructure(['_debugbar' => [] ]);
    }
}
