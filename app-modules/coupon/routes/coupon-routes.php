<?php

use Illuminate\Support\Facades\Route;
use Modules\Coupon\Http\Controllers\Admin\CouponController;

// Admin routes (not localized)
Route::middleware(['web', 'auth', 'role.access:developer,admin,employee,accounts'])->prefix('admin')->name('coupon::admin.')->group(function() {
    
    // Coupons Management
    Route::prefix('coupons')->name('coupons.')->group(function() {
        Route::get('/', [CouponController::class, 'index'])->name('index');
        Route::post('/json', [CouponController::class, 'json'])->name('json');
        Route::get('/create', [CouponController::class, 'create'])->name('create');
        Route::post('/', [CouponController::class, 'store'])->name('store');
        Route::get('/{coupon}', [CouponController::class, 'show'])->name('show');
        Route::get('/{coupon}/edit', [CouponController::class, 'edit'])->name('edit');
        Route::put('/{coupon}', [CouponController::class, 'update'])->name('update');
        Route::delete('/{coupon}', [CouponController::class, 'destroy'])->name('destroy');
        Route::post('/{coupon}/toggle-status', [CouponController::class, 'toggleStatus'])->name('toggle-status');
    });
    
    // Usage Report
    Route::get('/coupon-usage-report', [CouponController::class, 'usageReport'])->name('coupons.usage-report');
    Route::post('/coupon-usage-report/json', [CouponController::class, 'usageReportJson'])->name('coupons.usage-report.json');
    
});
