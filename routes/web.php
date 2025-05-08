<?php

use App\Http\Controllers\Admin\AssetController as AdminAsset;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\ConditionContoller as AdminCondition;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\DepartmentController as AdminDepartment;
use App\Http\Controllers\Admin\DivisionController as AdminDivision;
use App\Http\Controllers\Admin\GroupController as AdminGroup;
use App\Http\Controllers\Admin\ScopeController as AdminScope;
use App\Http\Controllers\Admin\SubCategoryController as AdminSubCategory;
use App\Http\Controllers\Admin\UserAccountController as AdminUserAccount;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\AssetSubmissionController as UserAssetSubmission;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login-with-nik', [AuthController::class, 'loginWithNik'])->name('login-with-nik');
Route::post('/login', [AuthController::class, 'do_login'])->name('do-login');

Route::middleware(['role:admin,user'])->group(function () {
    Route::prefix('/')->name('user.')->group(function () {
        Route::get('/', [UserDashboard::class, 'index'])->name('dashboard');
        Route::prefix('/assets')->name('assets.')->group(function () {
            Route::get('/history', [UserAssetSubmission::class, 'index'])->name('history');
            Route::get('/form', [UserAssetSubmission::class, 'form'])->name('form');
        });
    });
});

Route::middleware(['role:admin'])->group(function () {
    Route::prefix('/admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::prefix('/master')->name('master.')->group(function () {
            Route::prefix('/groups')->name('group.')->group(function () {
                Route::get('/', [AdminGroup::class, 'index'])->name('index');
                Route::get('/last-code', [AdminGroup::class, 'lastCode'])->name('last-code');
                Route::post('/', [AdminGroup::class, 'store'])->name('store');
                Route::put('/{id}', [AdminGroup::class, 'update'])->name('update');
                Route::delete('/{id}', [AdminGroup::class, 'destroy'])->name('destroy');
            });
            Route::prefix('/scopes')->name('scope.')->group(function () {
                Route::get('/', [AdminScope::class, 'index'])->name('index');
                Route::get('/last-code', [AdminScope::class, 'lastCode'])->name('last-code');
                Route::post('/', [AdminScope::class, 'store'])->name('store');
                Route::put('/{id}', [AdminScope::class, 'update'])->name('update');
                Route::delete('/{id}', [AdminScope::class, 'destroy'])->name('destroy');
            });
            Route::prefix('/categories')->name('category.')->group(function () {
                Route::get('/', [AdminCategory::class, 'index'])->name('index');
                Route::get('/last-code', [AdminCategory::class, 'lastCode'])->name('last-code');
                Route::post('/', [AdminCategory::class, 'store'])->name('store');
                Route::put('/{id}', [AdminCategory::class, 'update'])->name('update');
                Route::delete('/{id}', [AdminCategory::class, 'destroy'])->name('destroy');
            });
            Route::prefix('/sub-categories')->name('sub-category.')->group(function () {
                Route::get('/', [AdminSubCategory::class, 'index'])->name('index');
                Route::get('/last-code', [AdminSubCategory::class, 'lastCode'])->name('last-code');
                Route::post('/', [AdminSubCategory::class, 'store'])->name('store');
                Route::put('/{id}', [AdminSubCategory::class, 'update'])->name('update');
                Route::delete('/{id}', [AdminSubCategory::class, 'destroy'])->name('destroy');
            });
            Route::prefix('/departments')->name('departments.')->group(function () {
                Route::get('/', [AdminDepartment::class, 'index'])->name('index');
                Route::post('/', [AdminDepartment::class, 'store'])->name('store');
                Route::put('/{id}', [AdminDepartment::class, 'update'])->name('update');
                Route::delete('/{id}', [AdminDepartment::class, 'destroy'])->name('destroy');
            });
            Route::prefix('/divisions')->name('divisions.')->group(function () {
                Route::get('/', [AdminDivision::class, 'index'])->name('index');
                Route::post('/', [AdminDivision::class, 'store'])->name('store');
                Route::put('/{id}', [AdminDivision::class, 'update'])->name('update');
                Route::delete('/{id}', [AdminDivision::class, 'destroy'])->name('destroy');
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
        Route::prefix('/assets')->name('asset.')->group(function () {
            Route::get('/', [AdminAsset::class, 'index'])->name('index');
            Route::get('/', [AdminAsset::class, 'data'])->name('data');
            Route::get('/last-code', [AdminAsset::class, 'lastCode'])->name('last-code');
            Route::get('/create', [AdminAsset::class, 'create'])->name('create');
            Route::post('/', [AdminAsset::class, 'store'])->name('store');
            Route::put('/{id}', [AdminAsset::class, 'update'])->name('update');
            Route::put('/{id}/update-status', [AdminAsset::class, 'updateStatus'])->name('update-status');
            Route::post('/print', [AdminAsset::class, 'printPdf'])->name('print');
        });
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
