<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\GroupController as AdminGroup;
use App\Http\Controllers\Admin\ScopeController as AdminScope;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::prefix('/admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::prefix('/master')->name('master.')->group(function () {
        Route::prefix('/groups')->name('group.')->group(function () {
            Route::get('/', [AdminGroup::class, 'index'])->name('index');
            Route::get('/last-code', [AdminGroup::class, 'lastCode'])->name('last-code');
            Route::post('/', [AdminGroup::class, 'store'])->name('store');
            Route::put('/update/{id}', [AdminGroup::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [AdminGroup::class, 'destroy'])->name('destroy');
        });
        Route::prefix('/scopes')->name('scope.')->group(function () {
            Route::get('/', [AdminScope::class, 'index'])->name('index');
            Route::get('/last-code', [AdminScope::class, 'lastCode'])->name('last-code');
            Route::post('/', [AdminScope::class, 'store'])->name('store');
            Route::put('/update/{id}', [AdminScope::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [AdminScope::class, 'destroy'])->name('destroy');
        });
        Route::prefix('/category')->name('category.')->group(function () {
            Route::get('/', [AdminDashboard::class, 'index'])->name('index');
        });
        Route::prefix('/sub-category')->name('sub-category.')->group(function () {
            Route::get('/', [AdminDashboard::class, 'index'])->name('index');
        });
    });
});

