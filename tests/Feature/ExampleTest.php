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

        // Guests should be able to see /home
        $response = $this->get('/home');
        $response->assertStatus(200);

        // Guests should be redirected to login when trying to access /favorite
        $response = $this->get('/favorite');
        $response->assertRedirect('/login');

        // Guests should be redirected to login when trying to access detail page
        $anime = \App\Models\Anime::create([
            'judul_anime' => 'Test Anime',
            'studio' => 'Test Studio',
            'genre' => 'Test Genre',
            'episode' => 12,
            'sinopsis' => 'Test Sinopsis',
            'rating' => 8.0,
            'gambar' => 'test.jpg'
        ]);
        $response = $this->get("/anime/{$anime->id}");
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
