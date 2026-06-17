<?php

namespace Tests\Feature;

use App\Models\Anime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnimeSearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create sample anime for testing
        Anime::create([
            'judul_anime' => 'Solo Leveling',
            'studio' => 'A-1 Pictures',
            'genre' => 'Action, Fantasy',
            'episode' => 12,
            'sinopsis' => 'Sung Jinwoo levels up.',
            'rating' => 8.70,
            'gambar' => 'solo.jpg',
        ]);

        Anime::create([
            'judul_anime' => 'One Piece',
            'studio' => 'Toei Animation',
            'genre' => 'Action, Adventure',
            'episode' => 1100,
            'sinopsis' => 'Luffy wants to be pirate king.',
            'rating' => 8.72,
            'gambar' => 'one_piece.jpg',
        ]);

        Anime::create([
            'judul_anime' => 'Attack on Titan',
            'studio' => 'Wit Studio',
            'genre' => 'Action, Drama',
            'episode' => 25,
            'sinopsis' => 'Eren vs Titans.',
            'rating' => 8.54,
            'gambar' => 'aot.jpg',
        ]);
    }

    public function test_api_returns_anime_titles_for_autocomplete(): void
    {
        $response = $this->getJson(route('api.anime.titles'));

        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJsonFragment(['judul_anime' => 'Solo Leveling']);
        $response->assertJsonFragment(['judul_anime' => 'One Piece']);
        $response->assertJsonFragment(['judul_anime' => 'Attack on Titan']);
    }

    public function test_search_exact_match_filters_specifically(): void
    {
        $response = $this->get('/anime?search=One Piece');

        $response->assertStatus(200);
        $response->assertSee('One Piece');
        $response->assertDontSee('Solo Leveling');
        $response->assertDontSee('Attack on Titan');
    }

    public function test_search_typo_autocorrects_and_filters_specifically(): void
    {
        // Typo: "solol eveling" -> should auto-correct to "Solo Leveling"
        $response = $this->get('/anime?search=solol eveling');

        $response->assertStatus(200);
        $response->assertSee('Solo Leveling');
        $response->assertSee('Mencari kata kunci');
        $response->assertSee('solol eveling');
        $response->assertDontSee('One Piece');
        $response->assertDontSee('Attack on Titan');
    }

    public function test_search_partial_typo_autocorrects_and_filters_specifically(): void
    {
        // Partial with typo: "atack" -> should auto-correct to "Attack on Titan"
        $response = $this->get('/anime?search=atack');

        $response->assertStatus(200);
        $response->assertSee('Attack on Titan');
        $response->assertDontSee('Solo Leveling');
        $response->assertDontSee('One Piece');
    }

    public function test_search_no_match_shows_empty_results(): void
    {
        $response = $this->get('/anime?search=unknownanimexyz');

        $response->assertStatus(200);
        $response->assertSee('Tidak ada anime yang cocok dengan pencarian Anda.');
        $response->assertDontSee('Solo Leveling');
        $response->assertDontSee('One Piece');
        $response->assertDontSee('Attack on Titan');
    }
}
