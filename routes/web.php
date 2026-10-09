<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy']);
});

Route::resource('posts', PostController::class)
    ->only(['index', 'show']);

Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
    ->name('comments.store');

Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
    ->middleware('auth')
    ->name('comments.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
