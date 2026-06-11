<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // Guests should be able to see the landing page
        $response = $this->get('/');
        $response->assertStatus(200);

        // Guests should be redirected to login when trying to access /home
        $response = $this->get('/home');
        $response->assertRedirect('/login');

        // Authenticated users should be redirected from / to /home
        $user = \App\Models\User::factory()->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertRedirect('/home');

        // Authenticated users should be able to see /home
        $response = $this->actingAs($user)->get('/home');
        $response->assertStatus(200);
    }
}
