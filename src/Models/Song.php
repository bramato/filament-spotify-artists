<?php

namespace Bramato\FilamentSpotifyManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = ['album_id', 'name', 'spotify_id', 'duration_ms'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}