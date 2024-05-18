<?php

use Bramato\FilamentStripeManager\Http\Controllers\CategoryController;
use Bramato\FilamentStripeManager\Http\Controllers\CommentController;
use Bramato\FilamentStripeManager\Http\Controllers\PostController;
use Bramato\FilamentStripeManager\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::post('/filamentstripemanager/webhook',[\Bramato\FilamentStripeManager\Http\Controllers\WebhookController::class,'save'])->name('filamentstripemanager.webhook');
   
