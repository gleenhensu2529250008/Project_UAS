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
        $search = request('search');
        $correctedSearch = null;
        $originalSearch = null;

        if ($search) {
            $originalSearch = $search;
            $allAnimes = Anime::all();
            $bestMatch = null;
            $highestScore = 0;

            foreach ($allAnimes as $anime) {
                $score = $this->calculateSimilarity($search, $anime->judul_anime);
                if ($score > $highestScore) {
                    $highestScore = $score;
                    $bestMatch = $anime;
                }
            }

            if ($bestMatch && $highestScore >= 0.35) {
                $correctedSearch = $bestMatch->judul_anime;
                $animes = collect([$bestMatch]);
            } else {
                $animes = collect();
            }
            $recentAnimes = collect();
            $trendingAnimes = collect();
        } else {
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
                    WHEN judul_anime = 'Frieren: Beyond Journey''s End' THEN 9
                    WHEN judul_anime = 'Blue Archive' THEN 10
                    ELSE 100
                END ASC
            ")->get();
        }

        return view('anime.list-anime', compact('animes', 'recentAnimes', 'trendingAnimes', 'correctedSearch', 'originalSearch'));
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

public function getTitlesJson()
{
    $titles = Anime::select('id', 'judul_anime')->get();
    return response()->json($titles);
}

private function calculateSimilarity($query, $title)
{
    $query = strtolower(trim($query));
    $title = strtolower(trim($title));

    if ($query === $title) {
        return 1.0;
    }

    if (strlen($query) > 255 || strlen($title) > 255) {
        return 0;
    }

    // Exact substring match
    if (str_contains($title, $query)) {
        return 0.8 + (strlen($query) / strlen($title)) * 0.2;
    }
    
    if (str_contains($query, $title)) {
        return 0.8 + (strlen($title) / strlen($query)) * 0.2;
    }

    // Levenshtein distance on full strings
    $lev = levenshtein($query, $title);
    $maxLen = max(strlen($query), strlen($title));
    $fullScore = $maxLen > 0 ? (1 - ($lev / $maxLen)) : 0;

    // Word-level similarity to catch typos in specific words
    $queryWords = preg_split('/[\s,.:;!?_-]+/', $query, -1, PREG_SPLIT_NO_EMPTY);
    $titleWords = preg_split('/[\s,.:;!?_-]+/', $title, -1, PREG_SPLIT_NO_EMPTY);

    $wordScores = [];
    foreach ($queryWords as $qw) {
        $bestWordScore = 0;
        foreach ($titleWords as $tw) {
            if ($qw === $tw) {
                $wordScore = 1.0;
            } elseif (str_contains($tw, $qw)) {
                $wordScore = 0.8 * (strlen($qw) / strlen($tw));
            } elseif (str_contains($qw, $tw)) {
                $wordScore = 0.8 * (strlen($tw) / strlen($qw));
            } else {
                $wLev = levenshtein($qw, $tw);
                $wMax = max(strlen($qw), strlen($tw));
                $wordScore = $wMax > 0 ? (1 - ($wLev / $wMax)) : 0;
            }

            if ($wordScore > $bestWordScore) {
                $bestWordScore = $wordScore;
            }
        }
        $wordScores[] = $bestWordScore;
    }

    $avgWordScore = count($wordScores) > 0 ? array_sum($wordScores) / count($wordScores) : 0;

    return max($fullScore, $avgWordScore);
}
}
