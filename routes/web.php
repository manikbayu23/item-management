<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\ConditionContoller as AdminCondition;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\GroupController as AdminGroup;
use App\Http\Controllers\Admin\ScopeController as AdminScope;
use App\Http\Controllers\Admin\SubCategoryController as AdminSubCategory;
use App\Http\Controllers\Admin\UserAccountController as AdminUserAccount;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'do_login'])->name('do-login');

Route::middleware(['role:admin'])->group(function () {
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
                Route::get('/', [AdminCategory::class, 'index'])->name('index');
                Route::get('/last-code', [AdminCategory::class, 'lastCode'])->name('last-code');
                Route::post('/', [AdminCategory::class, 'store'])->name('store');
                Route::put('/update/{id}', [AdminCategory::class, 'update'])->name('update');
                Route::delete('/destroy/{id}', [AdminCategory::class, 'destroy'])->name('destroy');
            });
            Route::prefix('/sub-category')->name('sub-category.')->group(function () {
                Route::get('/', [AdminSubCategory::class, 'index'])->name('index');
                Route::get('/last-code', [AdminSubCategory::class, 'lastCode'])->name('last-code');
                Route::post('/', [AdminSubCategory::class, 'store'])->name('store');
                Route::put('/update/{id}', [AdminSubCategory::class, 'update'])->name('update');
                Route::delete('/destroy/{id}', [AdminSubCategory::class, 'destroy'])->name('destroy');
            });
        });
        Route::prefix('/user-accounts')->name('user-accounts.')->group(function () {
            Route::get('/', [AdminUserAccount::class, 'index'])->name('index');
            Route::get('/create', [AdminUserAccount::class, 'create'])->name('create');
            Route::post('/', [AdminUserAccount::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminUserAccount::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminUserAccount::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminUserAccount::class, 'destroy'])->name('destroy');
            Route::get('/profile-picture/{folder}/{filename}', [AdminUserAccount::class, 'profile_picture'])->name('profile-picture');
        });
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
