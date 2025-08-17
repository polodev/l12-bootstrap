<?php

use Illuminate\Support\Facades\Route;
use Modules\Page\Http\Controllers\PageController;
use Modules\Page\Http\Controllers\PageFrontendController;

// Admin Routes (No localization - admin/dashboard only)
Route::prefix('admin-dashboard')->name('page::admin.')->middleware(['web', 'auth', 'role.access:developer,admin,employee,accounts'])->group(function () {
    
    // Page Management Routes
    Route::prefix('pages')->name('pages.')->group(function () {
        Route::get('/', [PageController::class, 'index'])->name('index');
        Route::post('/json', [PageController::class, 'indexJson'])->name('json');
        
        Route::get('/create', [PageController::class, 'create'])->name('create');
        Route::post('/', [PageController::class, 'store'])->name('store');
        
        Route::get('/{page}', [PageController::class, 'show'])->name('show');
        Route::get('/{page}/edit', [PageController::class, 'edit'])->name('edit');
        Route::put('/{page}', [PageController::class, 'update'])->name('update');
        Route::delete('/{page}', [PageController::class, 'destroy'])->name('destroy');
    });
});

// Frontend Routes (With localization support)
Route::group([
    'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(),
    'middleware' => ['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function() {
    
    // Page Frontend Routes
    Route::get('/pages/{slug}', [PageFrontendController::class, 'show'])->name('page::pages.show');
});