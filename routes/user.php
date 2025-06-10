<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;

Route::prefix('user')->middleware('userMiddleware')->group(function () {
    //Diret to user homepage
    Route::get('/home', [UserController::class, 'userHome'])->name('user.homePage');

    //Profile Routes
    Route::prefix('profile')->group(function(){
        //profile Edit
        Route::get('/edit',[ProfileController::class, 'create'])->name('user.profileEdit');
        Route::post('/edit',[ProfileController::class,'store'])->name('user.profileEditStore');

        //Password change
        Route::get('/changepassword',[ProfileController::class,'changePassword'])->name('user.changePassword');
        Route::post('/changepassword', [ProfileController::class, 'changePasswordStore'])->name('user.changePasswordStore');
    });
});
