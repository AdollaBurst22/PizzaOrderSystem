<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'mainDashboard'])->name('admin#mainDashboard');
});
