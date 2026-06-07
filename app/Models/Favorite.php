<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'anime_id'
    ];

    public function anime()
    {
        return $this->belongsTo(Anime::class);
    }
}