<?php

namespace Bramato\FilamentSpotifyManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'spotify_id', 'genre', 'image_url'];

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

}