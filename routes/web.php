<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepartmentController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Các route phải qua middleware kiểm tra thiết lập hệ thống.
Route::middleware(['check.setup'])->group(function () {
    // Route mặc định chuyển hướng đến dashboard.
    Route::get('/', function () {
        return redirect('/dashboard');
    });

    // Các route yêu cầu người dùng phải xác thực và không có vai trò Pending.
    Route::middleware(['auth', 'check.pending'])->group(function () {
        // Route dashboard dành cho người dùng đã xác thực và không có vai trò Pending.
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');

        // Route quản lý profile dành cho người dùng đã xác thực và không có vai trò Pending.
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Các route dành cho quản trị viên.
        Route::middleware(['role:Administrator'])->group(function () {
            // Route quản lý người dùng.
            Route::get('/users', [AdminController::class, 'index'])->name('users.index');
            Route::patch('/users/{user}', [AdminController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
            // Route quản lý phòng ban.
            Route::resource('departments', DepartmentController::class);
        });
    });

    // Định tuyến xác thực.
    require __DIR__.'/auth.php';

    // Route cho thông báo khi tài khoản đang chờ xác thực, chỉ dành cho vai trò Pending.
    Route::get('/pending-verification', function () {
        return Inertia::render('PendingVerification');
    })->name('pending.verification')->middleware(['role:Pending']);
});

// Route này chỉ sử dụng một lần khi setup hệ thống.
Route::get('/setup', [SetupController::class, 'index'])->name('setup.index');
Route::post('/setup', [SetupController::class, 'store'])->name('setup.store');
