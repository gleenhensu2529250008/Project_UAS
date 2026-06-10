<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\FavoriteController;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('guest.welcome');
    })->name('welcome');

    Route::get('/home', [AnimeController::class, 'home'])
        ->name('home');

    Route::get('/favorite', function () {
        return view('anime.fav-anime');
    })->name('favorite');

    Route::resource('anime', AnimeController::class);
    Route::resource('favorite', FavoriteController::class)
        ->only(['index', 'store', 'destroy']);
});