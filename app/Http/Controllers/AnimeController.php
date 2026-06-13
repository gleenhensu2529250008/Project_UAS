<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Favorite;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $animes = Anime::orderBy('rating', 'desc')->get();
        $recentAnimes = Anime::orderBy('created_at', 'desc')->get();
        $trendingAnimes = Anime::orderByRaw("
            CASE 
                WHEN judul_anime = 'Attack on Titan' THEN 1
                WHEN judul_anime = 'My Hero Academia' THEN 2
                WHEN judul_anime = 'Demon Slayer: Kimetsu no Yaiba' THEN 3
                WHEN judul_anime = 'Jujutsu Kaisen' THEN 4
                WHEN judul_anime = 'One Piece' THEN 5
                WHEN judul_anime = 'Re:Zero - Starting Life in Another World' THEN 6
                WHEN judul_anime = 'Solo Leveling' THEN 7
                WHEN judul_anime = 'Dr. Stone: New World' THEN 8
                WHEN judul_anime = 'Frieren: Beyond Journey\'s End' THEN 9
                WHEN judul_anime = 'Blue Archive' THEN 10
                ELSE 100
            END ASC
        ")->get();

        return view('anime.list-anime', compact('animes', 'recentAnimes', 'trendingAnimes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('anime.create-anime');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_anime' => ['required', 'min:3'],
            'studio' => ['required', 'min:3'],
            'genre' => ['required'],
            'episode' => ['required'],
            'sinopsis' => ['required'],
            'rating' => ['required'],
            'gambar' => ['required_without:gambar_url', 'nullable', 'image'],
            'gambar_url' => ['required_without:gambar', 'nullable', 'url']
        ]);

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('anime', 'public');
        } elseif ($request->filled('gambar_url')) {
            try {
                $response = \Illuminate\Support\Facades\Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'image/jpeg,image/png,image/*;q=0.8'
                ])->timeout(15)->get($request->gambar_url);

                if ($response->successful()) {
                    $contents = $response->body();
                    $filename = 'anime/' . uniqid() . '.jpg';
                    \Illuminate\Support\Facades\Storage::disk('public')->put($filename, $contents);
                    $gambar = $filename;
                } else {
                    $gambar = $request->gambar_url; // fallback to URL if download failed
                }
            } catch (\Exception $e) {
                $gambar = $request->gambar_url; // fallback to URL if exception thrown
            }
        } else {
            return redirect()->back()->withErrors(['gambar' => 'Gambar/Poster Anime wajib diisi atau dicari secara otomatis.']);
        }

        Anime::create([
            'judul_anime' => $request->judul_anime,
            'studio' => $request->studio,
            'genre' => $request->genre,
            'episode' => $request->episode,
            'sinopsis' => $request->sinopsis,
            'rating' => $request->rating,
            'gambar' => $gambar
        ]);

        return redirect('/anime')
            ->with('success', 'Anime berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Anime $anime)
    {
        return view('anime.detail-anime', compact('anime'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anime $anime)
    {
        return view('anime.edit-anime', [
            'anime' => $anime
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anime $anime)
    {
        $request->validate([
            'judul_anime' => ['required', 'min:3'],
            'studio' => ['required', 'min:3'],
            'genre' => ['required'],
            'episode' => ['required'],
            'sinopsis' => ['required'],
            'rating' => ['required']
        ]);

        $data = [
            'judul_anime' => $request->judul_anime,
            'studio' => $request->studio,
            'genre' => $request->genre,
            'episode' => $request->episode,
            'sinopsis' => $request->sinopsis,
            'rating' => $request->rating
        ];

        if ($request->hasFile('gambar')) {
            $request->validate([
                'gambar' => ['image']
            ]);
            // Store the new image
            $data['gambar'] = $request->file('gambar')->store('anime', 'public');
            
            // Delete old image if it's not a URL and exists
            if ($anime->gambar && !filter_var($anime->gambar, FILTER_VALIDATE_URL)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($anime->gambar);
            }
        }

        $anime->update($data);

        return redirect('/anime')
            ->with('success', 'Anime berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anime $anime)
    {
        $anime->delete();

        return redirect()
            ->back()
            ->with('success', 'Anime berhasil dihapus');
    }
    public function home()
{
    $animes = Anime::orderBy('created_at', 'desc')
        ->take(8)
        ->get();

    return view('anime.show-anime', compact('animes'));
}
public function favorite()
{
    $favorites = Favorite::with('anime')->get();

    return view(
        'anime.fav-anime',
        compact('favorites')
    );
}
public function addFavorite(Anime $anime)
{
    Favorite::firstOrCreate([
        'anime_id' => $anime->id
    ]);

    return redirect()
        ->back()
        ->with('success', 'Anime ditambahkan ke Favorite');
}
public function removeFavorite($id)
{
    Favorite::where('anime_id', $id)->delete();

    return redirect()
        ->back()
        ->with('success', 'Anime dihapus dari Favorite');
}
}
