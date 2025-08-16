<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\PaymentController;
use Modules\Payment\Http\Controllers\FrontendPaymentController;
use Modules\Payment\Http\Controllers\SslCommerzController;

// Admin Routes (No localization - admin/dashboard only)
Route::prefix('admin-dashboard')->name('payment::admin.')->middleware(['web', 'auth'])->group(function () {
    
    // Payment Management Routes
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::post('/json', [PaymentController::class, 'indexJson'])->name('json');
        Route::get('/create-custom-payment', [PaymentController::class, 'create'])->name('create_custom_payment');
        Route::post('/create-custom-payment', [PaymentController::class, 'store'])->name('store_custom_payment');
        Route::get('/{payment}', [PaymentController::class, 'show'])->name('show');
        Route::get('/{payment}/edit', [PaymentController::class, 'edit'])->name('edit');
        Route::put('/{payment}', [PaymentController::class, 'update'])->name('update');
        Route::delete('/{payment}', [PaymentController::class, 'destroy'])->name('destroy');
    });

});

// Frontend Routes (With localization support)
Route::group([
    'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'web'],
    'as' => 'payment::'
], function() {
    
    // Custom Payment Form Routes
    Route::get('/create-custom-payment', [FrontendPaymentController::class, 'showCustomPaymentForm'])->name('custom-payment.form');
    Route::post('/create-custom-payment', [FrontendPaymentController::class, 'submitCustomPaymentForm'])->name('custom-payment.submit');
    
    // Payment Processing Routes
    Route::get('/payments/{payment}', [FrontendPaymentController::class, 'showPayment'])->name('payments.show');
    Route::post('/payments/{payment}/process', [FrontendPaymentController::class, 'processPayment'])->name('payments.process');
    Route::post('/payments/{payment}/submit-manual', [FrontendPaymentController::class, 'submitManualPayment'])->name('payments.submit-manual');
    
    // Payment Confirmation Route
    Route::get('/payment-confirmation/{payment}', [FrontendPaymentController::class, 'showPaymentConfirmation'])->name('payments.confirmation');
});

// SSL Commerz Callback Routes (No localization - these are called by SSL Commerz gateway)
Route::middleware(['web'])->name('payment::')->group(function () {
    Route::post('/sslcommerz/success/{store?}', [SslCommerzController::class, 'success'])->name('sslcommerz.success');
    Route::post('/sslcommerz/fail/{store?}', [SslCommerzController::class, 'fail'])->name('sslcommerz.fail');
    Route::post('/sslcommerz/cancel/{store?}', [SslCommerzController::class, 'cancel'])->name('sslcommerz.cancel');
    Route::post('/sslcommerz/ipn/{store?}', [SslCommerzController::class, 'ipn'])->name('sslcommerz.ipn');
});