<?php

use Illuminate\Support\Facades\Route;
use Modules\CustomerDashboard\Http\Controllers\AccountController;
use Modules\CustomerDashboard\Http\Controllers\AddressController;
use Modules\CustomerDashboard\Http\Controllers\Settings\ProfileController;
use Modules\CustomerDashboard\Http\Controllers\Settings\PasswordController;
use Modules\CustomerDashboard\Http\Controllers\Settings\AppearanceController;

// Customer Account routes (localized) - All customer-facing routes should support language switching
Route::group([
    'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(),
    'middleware' => ['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    Route::middleware(['auth', 'verified.email_or_mobile'])->group(function () {
        
        // Account routes
        Route::prefix('accounts')->name('accounts.')->group(function () {
            Route::get('/', [AccountController::class, 'index'])->name('index');
            Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
            Route::get('/wishlist', [AccountController::class, 'wishlist'])->name('wishlist');
            Route::get('/support', [AccountController::class, 'support'])->name('support');
            
            // Settings routes (under accounts)
            Route::prefix('settings')->name('settings.')->group(function () {
                Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
                Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
                Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
                Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
                Route::get('/password', [PasswordController::class, 'edit'])->name('password.edit');
                Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
                Route::get('/appearance', [AppearanceController::class, 'edit'])->name('appearance.edit');
            });
            
            // Address routes (under accounts)
            Route::resource('addresses', AddressController::class);
            Route::post('addresses/{address}/set-default', [AddressController::class, 'setDefault'])->name('addresses.set-default');
        });
    });
});
