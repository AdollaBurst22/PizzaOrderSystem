<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialLoginController;

require_once __DIR__.'/admin.php';
require_once __DIR__.'/user.php';

Route::get('/', function () {
    return view('authentication.register');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Social Login Routes
Route::get('/auth/{provider}/redirect', [SocialLoginController::class, 'socialRedirect'])->name('socialRedirect');

Route::get('/auth/{provider}/callback', [SocialLoginController::class, 'socialCallback'])->name('socialCallback');

require __DIR__.'/auth.php';
