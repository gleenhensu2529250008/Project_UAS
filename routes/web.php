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
    if (Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('home');
    }
    return view('guest.welcome');
})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/home', [AnimeController::class, 'home'])
        ->name('home');

    Route::get('/favorite', function () {
        return view('anime.fav-anime');
    })->name('favorite');

    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile');

    // Public/User authenticated anime routes
    Route::get('/anime', [AnimeController::class, 'index'])->name('anime.index');

    // Admin only anime and user management routes
    Route::middleware('admin')->group(function () {
        Route::get('/anime/create', [AnimeController::class, 'create'])->name('anime.create');
        Route::post('/anime', [AnimeController::class, 'store'])->name('anime.store');
        Route::get('/anime/{anime}/edit', [AnimeController::class, 'edit'])->name('anime.edit');
        Route::put('/anime/{anime}', [AnimeController::class, 'update'])->name('anime.update');
        Route::delete('/anime/{anime}', [AnimeController::class, 'destroy'])->name('anime.destroy');

        // User Management routes
        Route::get('/admin/users', [\App\Http\Controllers\AdminUserController::class, 'index'])->name('admin.users.index');
        Route::post('/admin/users/{user}/toggle-admin', [\App\Http\Controllers\AdminUserController::class, 'toggleAdmin'])->name('admin.users.toggle');
        Route::post('/admin/users', [\App\Http\Controllers\AdminUserController::class, 'store'])->name('admin.users.store');
    });

    Route::get('/anime/{anime}', [AnimeController::class, 'show'])->name('anime.show');

    Route::resource('favorite', FavoriteController::class)
        ->only(['index', 'store', 'destroy']);
});