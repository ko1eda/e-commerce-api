<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /** @test */
    public function testBasicTest()
    {
        $response = $this->get('/api');

        $response->assertStatus(200);
    }
}
