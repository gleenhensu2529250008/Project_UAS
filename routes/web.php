<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;
use App\Models\Anime;


/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('guest.welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| Home (Show Anime)
|--------------------------------------------------------------------------
*/

Route::get('/home', function () {
   return view('anime.show-anime');
})->name('home');


/*
|--------------------------------------------------------------------------
| Anime List
|--------------------------------------------------------------------------
*/

Route::get('/anime', function () {

    $animes = Anime::all();

    return view('anime.list-anime', compact('animes'));

})->name('anime.index');

/*
|--------------------------------------------------------------------------
| Favorite Anime
|--------------------------------------------------------------------------
*/

Route::get('/favorite', function () {
    return view('anime.fav-anime');
})->name('favorite');

/*
|--------------------------------------------------------------------------
| Login & Register
|--------------------------------------------------------------------------
*/

Route::get('/anime/create', function () {
    return view('anime.create-anime');
})->name('anime.create');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');


Route::get('/home', [AnimeController::class, 'index'])
    ->name('home');

Route::post('/anime', [AnimeController::class, 'store']);

Route::get('/anime/create', [AnimeController::class, 'create'])
    ->name('anime.create');

Route::post('/anime', [AnimeController::class, 'store'])
    ->name('anime.store');