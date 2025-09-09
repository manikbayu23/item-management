<?php

use App\Http\Controllers\Admin\AssetController as AdminAsset;
use App\Http\Controllers\Admin\BorrowItemController as AdminBorrowItem;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\ConditionContoller as AdminCondition;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\DepartmentController as AdminDepartment;
use App\Http\Controllers\Admin\DivisionController as AdminDivision;
use App\Http\Controllers\Admin\GroupController as AdminGroup;
use App\Http\Controllers\Admin\ItemController as AdminItem;
use App\Http\Controllers\Admin\PositionController as AdminPosition;
use App\Http\Controllers\Admin\RoomController as AdminRoom;
use App\Http\Controllers\Admin\RoomInventroyController as AdminRoomInventory;
use App\Http\Controllers\Admin\ScopeController as AdminScope;
use App\Http\Controllers\Admin\SubCategoryController as AdminSubCategory;
use App\Http\Controllers\Admin\UserAccountController as AdminUserAccount;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\AssetSubmissionController as UserAssetSubmission;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\HistoryController as UserHistory;
use App\Http\Controllers\User\ItemController as UserItem;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'do_login'])->name('do-login');

Route::middleware(['role:admin,pic,staff'])->group(function () {
    Route::prefix('/')->name('user')->group(function () {
        Route::get('/', [UserDashboard::class, 'index'])->name('.dashboard');
        Route::prefix('/items')->name('.item')->group(function () {
            Route::get('/', [UserItem::class, 'index']);
            Route::get('/{id}/form', [UserItem::class, 'form'])->name('.form');
            Route::post('/{id}/form', [UserItem::class, 'store'])->name('.store');
        });
        Route::prefix('/account')->name('.account')->group(function () {
            Route::get('/', [AccountController::class, 'index']);
            Route::put('/{id}', [AccountController::class, 'update'])->name('.update');
        });
        Route::prefix('/history')->name('.history')->group(function () {
            Route::get('/', [UserHistory::class, 'index']);
            Route::put('/{id}/cancel-form', [UserHistory::class, 'cancelForm'])->name('.cancel-form');
        });
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['role:pic,admin'])->group(function () {
    Route::prefix('/admin')->name('admin')->group(function () {
        Route::prefix('/dashboard')->name('.dashboard')->group(function () {
            Route::get('/', [AdminDashboard::class, 'index']);
            Route::get('/borrowings', [AdminDashboard::class, 'borrowings'])->name('.borrowings');
            Route::get('/borrowings-today', [AdminDashboard::class, 'borrowingsToday'])->name('.borrowings-today');
            Route::get('/users', [AdminDashboard::class, 'users'])->name('.users');
            Route::get('/online-users', [AdminDashboard::class, 'onlineUsers'])->name('.online-users');
        });

        Route::prefix('/masters')->name('.master')->group(function () {
            Route::prefix('/divisions')->name('.division')->group(function () {
                Route::get('/', [AdminDivision::class, 'index']);
                Route::post('/', [AdminDivision::class, 'store'])->name('.store');
                Route::put('/{id}', [AdminDivision::class, 'update'])->name('.update');
                Route::delete('/{id}', [AdminDivision::class, 'destroy'])->name('.destroy');
            });
            Route::prefix('/positions')->name('.position')->group(function () {
                Route::get('/', [AdminPosition::class, 'index']);
                Route::post('/', [AdminPosition::class, 'store'])->name('.store');
                Route::put('/{id}', [AdminPosition::class, 'update'])->name('.update');
                Route::delete('/{id}', [AdminPosition::class, 'destroy'])->name('.destroy');
            });
            Route::prefix('/rooms')->name('.room')->group(function () {
                Route::get('/', [AdminRoom::class, 'index']);
                Route::post('/', [AdminRoom::class, 'store'])->name('.store');
                Route::put('/{id}', [AdminRoom::class, 'update'])->name('.update');
                Route::delete('/{id}', [AdminRoom::class, 'destroy'])->name('.destroy');
                Route::post('/print', [AdminRoom::class, 'print'])->name('.print');
            });
            Route::prefix('/categories')->name('.category')->group(function () {
                Route::get('/', [AdminCategory::class, 'index']);
                Route::post('/', [AdminCategory::class, 'store'])->name('.store');
                Route::put('/{id}', [AdminCategory::class, 'update'])->name('.update');
                Route::delete('/{id}', [AdminCategory::class, 'destroy'])->name('.destroy');
            });
        });
        Route::prefix('/user-accounts')->name('.user-account')->group(function () {
            Route::get('/', [AdminUserAccount::class, 'index']);
            Route::get('/create', [AdminUserAccount::class, 'create'])->name('.create');
            Route::post('/', [AdminUserAccount::class, 'store'])->name('.store');
            Route::get('/{id}/edit', [AdminUserAccount::class, 'edit'])->name('.edit');
            Route::put('/{id}', [AdminUserAccount::class, 'update'])->name('.update');
            Route::delete('/{id}', [AdminUserAccount::class, 'destroy'])->name('.destroy');
            Route::get('/{id}/rooms', [AdminUserAccount::class, 'rooms'])->name('.rooms');
            Route::put('/{id}/rooms', [AdminUserAccount::class, 'updateRooms'])->name('.update-rooms');
            // Route::get('/profile-picture/{folder}/{filename}', [AdminUserAccount::class, 'profile_picture'])->name('profile-picture');
        });
        Route::prefix('/items')->name('.item')->group(function () {
            Route::get('/', [AdminItem::class, 'index']);
            Route::get('/data', action: [AdminItem::class, 'data'])->name('.data');
            Route::get('/last-code', [AdminItem::class, 'lastCode'])->name('.last-code');
            Route::get('/create', [AdminItem::class, 'create'])->name('.create');
            Route::post('/', [AdminItem::class, 'store'])->name('.store');
            Route::get('/{id}', [AdminItem::class, 'edit'])->name('.edit');
            Route::put('/{id}', [AdminItem::class, 'update'])->name('.update');
            Route::put('/{id}/update-status', [AdminItem::class, 'updateStatus'])->name('.update-status');
            Route::post('/print', [AdminItem::class, 'printPdf'])->name('.print');
        });
        Route::prefix('/room-inventory')->name('.room-inventory')->group(function () {
            Route::get('/', [AdminRoomInventory::class, 'index']);
            Route::get('/data', action: [AdminRoomInventory::class, 'data'])->name('.data');
            Route::post('/', [AdminRoomInventory::class, 'store'])->name('.store');
            Route::put('/{id}', [AdminRoomInventory::class, 'update'])->name('.update');
            Route::get('/export', [AdminRoomInventory::class, 'export'])->name('.export');
        });
        Route::prefix('/borrow-items')->name('.borrow-item')->group(function () {
            Route::get('/', [AdminBorrowItem::class, 'index']);
            Route::get('/data', action: [AdminBorrowItem::class, 'data'])->name('.data');
            Route::put('/{id}', [AdminBorrowItem::class, 'update'])->name('.update');
            Route::put('/{id}/reminder', [AdminBorrowItem::class, 'reminder'])->name('.reminder');
        });
        Route::get('/picture/{folder}/{filename}', function ($folder, $filename) {
            $path = storage_path("app/private/$folder/$filename");
            if (!file_exists($path)) {
                abort(404);
            }
            return response()->file($path);
        });
    });
});
