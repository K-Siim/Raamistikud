<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

    Route::resource('posts', PostController::class)->middleware(['auth', 'verified']);
    

    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');