<?php

use Bramato\FilamentSpotifyManager\Http\Controllers\SpotifyAuthController;
use Illuminate\Support\Facades\Route;


Route::get('/auth/spotify', [SpotifyAuthController::class, 'redirect'])->name('spotify.auth');
Route::get('/auth/spotify/callback', [SpotifyAuthController::class, 'callback'])->name('spotify.callback');
