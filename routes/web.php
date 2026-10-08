<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy']);
});

Route::resource('posts', PostController::class)
    ->only(['index', 'show']);

