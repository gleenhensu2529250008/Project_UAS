<?php

namespace Tests\Feature;

use App\Models\Anime;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AnimeCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_anime_with_uploaded_file(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('anime.store'), [
            'judul_anime' => 'Sousou no Frieren',
            'studio' => 'Madhouse',
            'genre' => 'Adventure, Fantasy',
            'episode' => 28,
            'sinopsis' => 'Frieren journeys to learn human hearts.',
            'rating' => 9.39,
            'gambar' => UploadedFile::fake()->image('frieren.jpg'),
        ]);

        $response->assertRedirect('/anime');
        $this->assertDatabaseHas('animes', [
            'judul_anime' => 'Sousou no Frieren',
            'studio' => 'Madhouse',
        ]);

        $anime = Anime::where('judul_anime', 'Sousou no Frieren')->first();
        $this->assertNotNull($anime->gambar);
        Storage::disk('public')->assertExists($anime->gambar);
    }

    public function test_admin_can_create_anime_with_gambar_url(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('anime.store'), [
            'judul_anime' => 'Solo Leveling Season 2',
            'studio' => 'A-1 Pictures',
            'genre' => 'Action, Fantasy',
            'episode' => 12,
            'sinopsis' => 'Jinwoo level up again.',
            'rating' => 8.80,
            'gambar_url' => 'https://cdn.myanimelist.net/images/anime/1801/142390.jpg',
        ]);

        $response->assertRedirect('/anime');
        $this->assertDatabaseHas('animes', [
            'judul_anime' => 'Solo Leveling Season 2',
            'studio' => 'A-1 Pictures',
            'gambar' => 'https://cdn.myanimelist.net/images/anime/1801/142390.jpg',
        ]);
    }
}
