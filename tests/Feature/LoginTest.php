<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Tests if sign up route exists.
     *
     * @group view
     * @return void
     */
    public function test_sign_up_route_exists()
    {
        $response = $this->get('/auth/sign-up');

        $response->assertStatus(200);
    }
}
