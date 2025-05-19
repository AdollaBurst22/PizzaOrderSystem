<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

Route::prefix('user')->group(function () {
    Route::get('/home', [UserController::class, 'userHome'])->name('user#homePage');
});
