<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Backend\AgentController;
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
    Route::prefix('agents')->controller(AgentController::class)->group(function() {
        Route::get('/', 'index')->name('admin.agents.index');
        Route::get('/create', 'create')->name('admin.agents.create');
        Route::post('/store', 'store')->name('admin.agents.store');
        Route::get('/edit', 'edit')->name('admin.agents.edit');
        Route::post('/update', 'update')->name('admin.agents.update');
        Route::post('/delete', 'delete')->name('admin.agents.delete');
    });
});