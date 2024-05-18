<?php

use Bramato\FilamentSpotifyManager\Http\Controllers\CategoryController;
use Bramato\FilamentSpotifyManager\Http\Controllers\CommentController;
use Bramato\FilamentSpotifyManager\Http\Controllers\PostController;
use Bramato\FilamentSpotifyManager\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::post('/filamentstripemanager/webhook',[\Bramato\FilamentSpotifyManager\Http\Controllers\WebhookController::class,'save'])->name('filamentstripemanager.webhook');
   
