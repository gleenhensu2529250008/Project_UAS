<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnimeSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Anime::truncate();

        \App\Models\Anime::create([
            'judul_anime' => 'Solo Leveling',
            'studio' => 'A-1 Pictures',
            'genre' => 'Action, Fantasy, Adventure',
            'episode' => 12,
            'sinopsis' => 'A world where hunters must battle deadly monsters to protect mankind. Sung Jinwoo, a low-ranking hunter, gains a mysterious system that allows him to level up without limit.',
            'rating' => 8.70,
            'gambar' => 'https://cdn.myanimelist.net/images/anime/1801/142390.jpg',
        ]);

        \App\Models\Anime::create([
            'judul_anime' => "Frieren: Beyond Journey's End",
            'studio' => 'Madhouse',
            'genre' => 'Adventure, Drama, Fantasy',
            'episode' => 28,
            'sinopsis' => 'After the party of heroes defeated the Demon King, mage Frieren embarks on a new journey to learn more about humans and magic, living through decades while her mortal comrades age.',
            'rating' => 9.39,
            'gambar' => 'https://cdn.myanimelist.net/images/anime/1015/138006.jpg',
        ]);

        \App\Models\Anime::create([
            'judul_anime' => 'Demon Slayer: Kimetsu no Yaiba',
            'studio' => 'ufotable',
            'genre' => 'Action, Fantasy, Historical',
            'episode' => 26,
            'sinopsis' => 'Tanjiro Kamado fights demons to restore the humanity of his younger sister, Nezuko, who was turned into a demon after their family was slaughtered.',
            'rating' => 8.49,
            'gambar' => 'https://cdn.myanimelist.net/images/anime/1286/99889.jpg',
        ]);

        \App\Models\Anime::create([
            'judul_anime' => 'Jujutsu Kaisen',
            'studio' => 'MAPPA',
            'genre' => 'Action, Fantasy, Supernatural',
            'episode' => 24,
            'sinopsis' => 'Yuji Itadori swallows a legendary curse and joins a specialized high school of jujutsu sorcerers to exorcise powerful curses and protect the innocent.',
            'rating' => 8.63,
            'gambar' => 'https://cdn.myanimelist.net/images/anime/1171/109222.jpg',
        ]);

        \App\Models\Anime::create([
            'judul_anime' => 'Attack on Titan',
            'studio' => 'Wit Studio',
            'genre' => 'Action, Drama, Suspense',
            'episode' => 25,
            'sinopsis' => 'Eren Yeager vows to cleanse the earth of Titans after his home is destroyed and his mother is devoured by the giant humanoid monstrosities.',
            'rating' => 8.54,
            'gambar' => 'https://cdn.myanimelist.net/images/anime/10/47347.jpg',
        ]);

        \App\Models\Anime::create([
            'judul_anime' => 'One Piece',
            'studio' => 'Toei Animation',
            'genre' => 'Action, Adventure, Fantasy',
            'episode' => 1100,
            'sinopsis' => 'Monkey D. Luffy and his crew sail across the Grand Line in search of the ultimate treasure, the One Piece, to become the next King of the Pirates.',
            'rating' => 8.72,
            'gambar' => 'https://cdn.myanimelist.net/images/anime/1244/138851.jpg',
        ]);

        \App\Models\Anime::create([
            'judul_anime' => 'My Hero Academia',
            'studio' => 'Bones',
            'genre' => 'Action, Sci-Fi',
            'episode' => 13,
            'sinopsis' => 'Izuku Midoriya, a boy born without superpowers in a world where they are the norm, inherits the power of the world\'s greatest hero and enrolls in a high school for heroes.',
            'rating' => 7.89,
            'gambar' => 'https://cdn.myanimelist.net/images/anime/10/78745.jpg',
        ]);

        \App\Models\Anime::create([
            'judul_anime' => 'Re:Zero - Starting Life in Another World',
            'studio' => 'White Fox',
            'genre' => 'Action, Drama, Fantasy, Suspense',
            'episode' => 25,
            'sinopsis' => 'Subaru Natsuki is suddenly transported to a fantasy world where he discovers that he possesses the unique ability to loop back in time whenever he dies.',
            'rating' => 8.24,
            'gambar' => 'https://cdn.myanimelist.net/images/anime/11/79410.jpg',
        ]);

        \App\Models\Anime::create([
            'judul_anime' => 'Blue Archive',
            'studio' => 'Yostar Pictures',
            'genre' => 'Fantasy',
            'episode' => 12,
            'sinopsis' => 'This is a short animation commemorating the 1.5th Anniversary of the popular app game "Blue Archive" from Yostar.',
            'rating' => 6.95,
            'gambar' => 'anime/CJZbJ70ftuQdWZsmJO2wT6acaemMyzYF3S0llOmv.jpg',
        ]);

        \App\Models\Anime::create([
            'judul_anime' => 'Dr. Stone: New World',
            'studio' => 'TMS Entertainment',
            'genre' => 'Adventure, Comedy',
            'episode' => 11,
            'sinopsis' => "With the ambitious Ryuusui Nanami on board, Senkuu Ishigami and his team are almost ready to sail the seas and reach the other side of the world—where the bizarre green light that petrified humanity originated. Thanks to the revival of a skillful chef, enough food is being prepared for the entire crew, and the incredible reinvention of the GPS promises to ensure safety on the open sea.\nPreparations for the upcoming journey progress swimmingly until Senkuu receives an eerie message from a mysterious source. More driven than ever, the scientist sets out to explore the new world and discover what it can offer for his scientific cause. Though the uncharted territories may hide unkind surprises, Senkuu, with a little help from science, is ready to take on any challenge.\n[Written by MAL Rewrite]",
            'rating' => 8.14,
            'gambar' => 'anime/6a2ad4c7accaf.jpg',
        ]);
    }
}
