<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Subscription\Http\Controllers\SubscriptionController;
use Modules\Subscription\Http\Controllers\Admin\SubscriptionPlanController;
use Modules\Subscription\Http\Controllers\Admin\UserSubscriptionController;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function() {
    
    // Public subscription routes
    Route::get('/pricing', [SubscriptionController::class, 'pricing'])->name('subscription.pricing');
    Route::get('/subscription/demo-component', function() {
        return view('subscription::demo-component');
    })->name('subscription.demo-component');
    
    // Authenticated subscription routes
    Route::middleware(['web', 'auth'])->group(function() {
        Route::get('/subscription/purchase/{plan}', [SubscriptionController::class, 'purchase'])->name('subscription.purchase');
        Route::post('/subscription/apply-coupon', [SubscriptionController::class, 'applyCoupon'])->name('subscription.apply-coupon');
        Route::post('/subscription/process-purchase', [SubscriptionController::class, 'processPurchase'])->name('subscription.process-purchase');
        Route::get('/subscription/success', [SubscriptionController::class, 'success'])->name('subscription.success');
    });
    
});

// Admin routes (not localized)
Route::middleware(['web', 'auth', 'role.access:developer,admin,employee,accounts'])->prefix('admin')->name('subscription::admin.')->group(function() {
    
    // Subscription Plans Management
    Route::prefix('subscription-plans')->name('plans.')->group(function() {
        Route::get('/', [SubscriptionPlanController::class, 'index'])->name('index');
        Route::post('/json', [SubscriptionPlanController::class, 'json'])->name('json');
        Route::get('/create', [SubscriptionPlanController::class, 'create'])->name('create');
        Route::post('/', [SubscriptionPlanController::class, 'store'])->name('store');
        Route::get('/{plan}', [SubscriptionPlanController::class, 'show'])->name('show');
        Route::get('/{plan}/edit', [SubscriptionPlanController::class, 'edit'])->name('edit');
        Route::put('/{plan}', [SubscriptionPlanController::class, 'update'])->name('update');
        Route::delete('/{plan}', [SubscriptionPlanController::class, 'destroy'])->name('destroy');
        Route::post('/{plan}/toggle-status', [SubscriptionPlanController::class, 'toggleStatus'])->name('toggle-status');
    });
    
    // User Subscriptions Management
    Route::prefix('user-subscriptions')->name('subscriptions.')->group(function() {
        Route::get('/', [UserSubscriptionController::class, 'index'])->name('index');
        Route::post('/json', [UserSubscriptionController::class, 'json'])->name('json');
        Route::get('/{subscription}', [UserSubscriptionController::class, 'show'])->name('show');
        Route::post('/{subscription}/cancel', [UserSubscriptionController::class, 'cancel'])->name('cancel');
        Route::post('/{subscription}/extend', [UserSubscriptionController::class, 'extend'])->name('extend');
    });
    
});
