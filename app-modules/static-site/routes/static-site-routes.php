<?php

use Modules\StaticSite\Http\Controllers\StaticSiteController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Frontend Routes (With localization support)
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function() {
    
    Route::get('/about', [StaticSiteController::class, 'about'])->name('static-site::about');
    
});
