<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Localized test routes for all layout components
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function() {
    
    // Test index page with links to all layouts
    Route::get('/test', function () {
        return view('test::index');
    })->name('test.index');

    // Customer Frontend Layout Test  
    Route::get('/test/customer-frontend', function () {
        return view('test::customer-frontend');
    })->name('test.customer-frontend');

    // Customer Account Layout Test
    Route::get('/test/customer-account', function () {
        return view('test::customer-account');
    })->name('test.customer-account');
});

// Admin Dashboard Layout Test (excluded from localization like other admin routes)
Route::middleware(['web'])->get('/test/admin-dashboard', function () {
    return view('test::admin-dashboard');
})->name('test.admin-dashboard');