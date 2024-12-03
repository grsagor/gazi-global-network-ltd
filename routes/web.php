<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function() {
    Route::controller(AuthController::class)->group(function() {
        Route::get('login', 'login')->name('auth.login');
        Route::post('login', 'loginPost')->name('auth.login.post');
        Route::post('logout', 'logout')->name('auth.logout');
    });
});

Route::prefix('admin')->group(function() {
    Route::prefix('dashboard')->controller(DashboardController::class)->group(function() {
        Route::get('/', 'index')->name('admin.dashboard.index');
        Route::get('/datatable', 'datatable')->name('admin.dashboard.datatable');
    });
});