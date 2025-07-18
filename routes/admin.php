<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SaleInformation;
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

    //Order Route Group
    Route::prefix('order')->group(function () {
        Route::get('/list',[OrderController::class,'orderList'])->name('admin.orderList');
        Route::get('/details/{orderCode}',[OrderController::class,'orderDetails'])->name('admin.orderDetails');
        Route::get('/reject',[OrderController::class,'orderReject'])->name('admin.orderReject');
        Route::post('/statusupdate', [OrderController::class, 'updateStatus'])->name('admin.orderStatusUpdate');
        Route::get('/confirm',[OrderController::class,'orderConfirm'])->name('admin.orderConfirm');

    });

    //Sale Information Route group
    Route::prefix('sale-info')->group(function(){
        Route::get('/list',[SaleInformation::class,'saleList'])->name('admin.saleList');
        Route::get('/details/{orderCode}',[SaleInformation::class,'saleDetails'])->name('admin.saleDetails');
    });

});


//Only Superadmin can access these Routes
Route::prefix('superadmin')->middleware('superadminMiddleware')->group(function () {
    Route::prefix('profile')->group(function(){

        //Create a new admin account
        Route::get('/newadmin',[SuperadminController::class, 'newAdminCreate'])->name('superadmin.newAdminCreate');
        Route::post('/newadmin', [SuperadminController::class, 'newAdminStore'])->name('superadmin.newAdminStore');

        //See the admin list // User List,User View, User Delete use the same url as admin account
        Route::get('/accountlist/{accountType}',[SuperadminController::class, 'accountList'])->name('superadmin.accountList');

        //Delete the admin account Route
        Route::get('/accountdelete/{accountId}', [SuperadminController::class, 'accountDelete'])->name('superadmin.accountDelete');

        //View the admin account details route
        Route::get('/account/view/{accountId}',[SuperadminController::class, 'accountView'])->name('superadmin.accountView');

        //Edit the admin account route
        Route::get('/adminaccount/update/{accountId}',[SuperadminController::class,'adminAccountUpdate'])->name('superadmin.adminAccountUpdate');
        Route::post('/adminaccount/update/{accountId}',[SuperadminController::class,'adminAccountUpdateStore'])->name('superadmin.adminAccountUpdateStore');

    });

    //Payment Methods related Routes
    Route::prefix('paymentmethod')->group(function(){

        //See the available Payment Methos
        Route::get('/list',[SuperadminController::class, 'paymentMethodList'])->name('superadmin.paymentMethodList');

        Route::post('/create',[SuperadminController::class,'paymentMethodCreate'])->name('superadmin.paymentMethodCreate');
        Route::get('/delete/{methodId}',[SuperadminController::class, 'paymentMethodDelete'])->name('superadmin.paymentMethodDelete');

        Route::get('/update/{methodId}',[SuperadminController::class,'paymentMethodUpdate'])->name('superadmin.paymentMethodUpdate');

        Route::post('/update',[SuperadminController::class,'paymentMethodUpdateStore'])->name('superadmin.paymentMethodUpdateStore');

    });

});

