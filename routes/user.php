<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

Route::prefix('user')->middleware('userMiddleware')->group(function () {
    Route::get('/home', [UserController::class, 'userHome'])->name('user#homePage');
});
