<?php

namespace Bramato\FilamentSpotifyManager\Models\Traits;

use Bramato\FilamentSpotifyManager\Models\Artist;

class HasSpotify
{
    public function artists()
    {
        return $this->belongsToMany(Artist::class);
    }
}