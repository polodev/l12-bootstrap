<?php

use Modules\Contact\Http\Controllers\ContactController;
use Modules\Contact\Http\Controllers\ContactFrontendController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Admin Routes
Route::prefix('admin-dashboard')->name('contact::admin.')->middleware(['web', 'auth'])->group(function () {
    
    // Contact Management Routes
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::post('/json', [ContactController::class, 'indexJson'])->name('json');
        Route::get('/{contact}', [ContactController::class, 'show'])->name('show');
        Route::get('/{contact}/edit', [ContactController::class, 'edit'])->name('edit');
        Route::put('/{contact}', [ContactController::class, 'update'])->name('update');
        Route::delete('/{contact}', [ContactController::class, 'destroy'])->name('destroy');
    });
});

// Frontend Routes (Localized)
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function() {
    
    // Contact Form Routes
    Route::prefix('contact')->name('contact::frontend.contacts.')->group(function () {
        Route::get('/', [ContactFrontendController::class, 'create'])->name('create');
        Route::post('/', [ContactFrontendController::class, 'store'])->name('store');
    });
});
