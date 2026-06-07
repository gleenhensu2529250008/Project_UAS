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
        $animes = Anime::orderBy('created_at', 'desc')->get();

        return view('anime.list-anime', compact('animes'));
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
            'gambar' => ['required', 'image']
        ]);

        $gambar = $request->file('gambar')
            ->store('anime', 'public');

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
            ->with('save', 'Anime berhasil ditambahkan');
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

        $anime->update([
            'judul_anime' => $request->judul_anime,
            'studio' => $request->studio,
            'genre' => $request->genre,
            'episode' => $request->episode,
            'sinopsis' => $request->sinopsis,
            'rating' => $request->rating
        ]);

        return redirect('/anime')
            ->with('edit', 'Anime berhasil diubah');
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
