<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminController;

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
        Route::get('/create',[ProductController::class,'productCreate'])->name('admin.productCreate');
    });

});
