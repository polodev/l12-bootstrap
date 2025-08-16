<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminDashboard\Http\Controllers\UserController;
use Modules\AdminDashboard\Http\Controllers\ActivityLogController;

Route::middleware(['web', 'auth', 'role.access:developer,admin,employee,accounts'])->group(function () {
    Route::prefix('admin')->name('admin-dashboard.')->group(function () {
        Route::get('/', function () {
            return view('admin-dashboard::index');
        })->name('index');
        
        Route::resource('users', UserController::class);
        Route::post('users-json', [UserController::class, 'indexJson'])->name('users.json');
        Route::post('users/{user}/verify-email', [UserController::class, 'verifyEmail'])->name('users.verify-email');
        Route::post('users/{user}/verify-mobile', [UserController::class, 'verifyMobile'])->name('users.verify-mobile');
        
        Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
        Route::post('activity-logs-json', [ActivityLogController::class, 'indexJson'])->name('activity-logs.json');
        Route::get('activity-logs/{activity}', [ActivityLogController::class, 'show'])->name('activity-logs.show');
        Route::delete('activity-logs/{activity}', [ActivityLogController::class, 'destroy'])->name('activity-logs.destroy');
    });
});
