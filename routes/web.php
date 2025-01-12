<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Backend\AgentController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PassengerController;
use App\Http\Middleware\CheckLogin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('auth.login'));
});

Route::prefix('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('login', 'login')->name('auth.login');
        Route::post('login', 'loginPost')->name('auth.login.post');
        Route::post('logout', 'logout')->name('auth.logout');

        Route::get('my-profile', 'myProfile')->name('auth.my.profile');
        Route::post('my-profile', 'updateMyProfile')->name('auth.my.profile.update');
    });
});

Route::middleware('checkLogin')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::prefix('dashboard')->controller(DashboardController::class)->group(function () {
            Route::get('/', 'index')->name('admin.dashboard.index');
            Route::get('/datatable', 'datatable')->name('admin.dashboard.datatable');
        });
        Route::prefix('users')->controller(AgentController::class)->group(function () {
            Route::get('/{role}', 'index')->name('admin.agents.index');
            Route::get('/list/{role}', 'list')->name('admin.agents.list');
            Route::get('/create/{role}', 'create')->name('admin.agents.create');
            Route::post('/store/{role}', 'store')->name('admin.agents.store');
            Route::get('/edit/{role}', 'edit')->name('admin.agents.edit');
            Route::post('/update/{role}', 'update')->name('admin.agents.update');
            Route::post('/delete/{role}', 'delete')->name('admin.agents.delete');
            Route::post('/status/{role}', 'status')->name('admin.agents.status');
        });
        Route::prefix('passengers')->controller(PassengerController::class)->group(function () {
            Route::get('/', 'index')->name('admin.passengers.index');
            Route::get('/list', 'list')->name('admin.passengers.list');
            Route::get('/print', 'print')->name('admin.passengers.print');
            Route::get('/create', 'create')->name('admin.passengers.create');
            Route::post('/store', 'store')->name('admin.passengers.store');
            Route::get('/edit', 'edit')->name('admin.passengers.edit');
            Route::post('/update', 'update')->name('admin.passengers.update');
            Route::post('/delete', 'delete')->name('admin.passengers.delete');
            Route::get('/{id}', 'details')->name('admin.passengers.details');
            Route::post('/status', 'status')->name('admin.agents.status');
        });
    });
});
