<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    protected $fillable = [
        'judul_anime',
        'studio',
        'genre',
        'episode',
        'sinopsis',
        'rating',
        'gambar'
    ];

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
