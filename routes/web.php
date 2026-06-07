<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\FavoriteController;

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
| Home
|--------------------------------------------------------------------------
*/

Route::get('/home', [AnimeController::class, 'home'])
    ->name('home');

/*
|--------------------------------------------------------------------------
| Favorite
|--------------------------------------------------------------------------
*/

Route::get('/favorite', function () {
    return view('anime.fav-anime');
})->name('favorite');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');


/*
|--------------------------------------------------------------------------
| Anime CRUD
|--------------------------------------------------------------------------
*/

Route::resource('anime', AnimeController::class);
Route::resource('favorite', FavoriteController::class)
    ->only(['index', 'store', 'destroy']);