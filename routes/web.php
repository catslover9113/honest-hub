<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ReviewController::class, 'index'])->name('user.index');

Route::get('product/search', [ProductController::class, 'search'])->name('product.search');


Route::get('/user/{id}', [UserController::class, 'show'])->name('user.profile');

Route::get('/welcome', function () {
    return view('welcome');
});

Route::post('review/{id}/like', [ReviewController::class, 'like'])->name('review.like');
Route::get('/search', [ProductController::class, 'search'])->name('search');

Route::get('/reviews/create', [ReviewController::class, 'create'])->name('review.create');


Route::post('/reviews', [ReviewController::class, 'store'])->name('review.store');
Route::post('/reviews', [ProductController::class, 'store'])->name('review.store');


Route::get('/dashboard', [ProductController::class, 'dashboardIndex'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    
    Route::post('/dashboard', [ProfileController::class, 'updateImage'])->name('profile.updateImage');

    
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
