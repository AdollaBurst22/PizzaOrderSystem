<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SuperadminController;

Route::prefix('admin')->middleware('adminMiddleware')->group(function () {
    //dashboard
    Route::get('/dashboard', [AdminController::class, 'mainDashboard'])->name('admin#mainDashboard');

    //Category Routes
    Route::prefix('category')->group(function () {
        //Route to Category
        Route::get('/list', [CategoryController::class, 'categoryList'])->name('admin#categoryList');

        //Create categories
        Route::post('/create', [CategoryController::class, 'categoryCreate'])->name('admin#categoryCreate');

        //Update categories
        Route::get('/update/{id}', [CategoryController::class, 'categoryUpdate'])->name('admin.categoryUpdate');
        Route::post('/update', [CategoryController::class, 'categoryUpdateStore'])->name('admin.categoryUpdateStore');

        //Category Delete
        Route::get('/delete/{id}',[CategoryController::class, 'categoryDelete'])->name('admin.categoryDelete');
    });
    //product route groups
    Route::prefix('product')->group(function () {
        //Product page and Create Product
        Route::get('/create',[ProductController::class,'productCreate'])->name('admin.productCreate');
        Route::post('/create',[ProductController::class, 'productCreateStore'])->name('admin.productCreateStore');

        //Product list and related pages
        Route::get('/list/{action?}', [ProductController::class, 'productList'])->name('admin.productList');
        Route::get('/details/{productId}', [ProductController::class,'productDetails'])->name('admin.productDetail');
        Route::get('/delete/{productId}', [ProductController::class, 'productDelete'])->name('admin.productDelete');
        Route::get('/update/{productId}',[ProductController::class,'productUpdate'])->name('admin.productUpdate');
        Route::post('/update', [ProductController::class,'productUpdateStore'])->name('admin.productUpdateStore');
    });

    //Profile Routes group
    Route::prefix('profile')->group(function () {
        //Password Changing
        Route::get('/passwordchange', [ProfileController::class,'passwordChange'])->name('admin.passwordChange');
        Route::post('/passwordchange', [ProfileController::class, 'passwordChangeStore'])->name('admin.passwordChangeStore');

        //Profile Update
        Route::get('/update', [ProfileController::class, 'profileUpdate'])->name('admin.profileUpdate');
        Route::post('/update', [ProfileController::class, 'profileUpdateStore'])->name('admin.profileUpdateStore');
    });

});


//Only Superadmin can access these Routes
Route::prefix('superadmin')->middleware('superadminMiddleware')->group(function () {
    Route::prefix('profile')->group(function(){

        //Create a new admin account
        Route::get('/newadmin',[SuperadminController::class, 'newAdminCreate'])->name('superadmin.newAdminCreate');
        Route::post('/newadmin', [SuperadminController::class, 'newAdminStore'])->name('superadmin.newAdminStore');

        //See the admin list
        Route::get('/adminlist',[SuperadminController::class, 'adminList'])->name('superadmin.adminList');
        Route::get('/admindelete/{accountId}', [SuperadminController::class, 'adminDelete'])->name('superadmin.adminDelete');

        //See the User list
        Route::get('/userlist', [SuperadminController::class, 'userList'])->name('superadmin.userList');

    });

    //Payment Methods related Routes
    Route::prefix('paymentmethod')->group(function(){

        //See the available Payment Methos
        Route::get('/create',[SuperadminController::class, 'paymentMethodCreate'])->name('superadmin.paymentMethodCreate');

        //Payment Methods List
        Route::get('/list', [SuperadminController::class, 'paymentMethodList'])->name('superadmin.paymentMethodList');
    });

});

