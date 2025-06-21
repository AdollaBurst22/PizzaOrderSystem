<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;

Route::prefix('user')->middleware('userMiddleware')->group(function () {
    //Diret to user homepage
    Route::get('/home', [UserController::class, 'userHome'])->name('user.homePage');

    //To Product Details Page
    Route::get('/home/productdetails/{productId}',[UserController::class,'productDetails'])->name('user.productDetails');

    //Product Comment
    Route::post('/home/productcomment',[UserController::class, 'productComment'])->name('user.productComment');

    //Comment delete
    Route::get('/home/deletecomment/{commentId}',[UserController::class, 'deleteComment'])->name('user.deleteComment');

    //Rate Product
    Route::post('/home/rateproduct',[UserController::class,'rateProduct'])->name('user.rateProduct');

    //Cart Routes
    Route::get('home/cart',[UserController::class, 'cartCreate'])->name('user.cartCreate');
    Route::post('/home/cart',[UserController::class, 'cartStore'])->name('user.cartStore');
    Route::post('/home/cartupdate',[UserController::class,'updateCart'])->name('user.cartUpdate');
    //Remove product from cart
    Route::post('/home/cartremove/{cartId}',[UserController::class,'removeFromCart'])->name('user.cartRemove');

    //Payment Routes
    Route::get('/home/payment',[UserController::class,'paymentCreate'])->name('user.paymentCreate');
    Route::post('home/payment',[UserController::class,'paymentStore'])->name('user.paymentStore');

    //Order Page Route
    Route::get('home/order',[UserController::class,'orderPage'])->name('user.orderPage');

    //Contact Us Page
    Route::get('home/contact',[UserController::class,'contactPage'])->name('user.contactPage');
    //Store Messages from Users
    Route::post('home/message',[UserController::class,'message'])->name('user.message');

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
