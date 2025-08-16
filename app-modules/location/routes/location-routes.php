<?php

use Illuminate\Support\Facades\Route;
use Modules\Location\Http\Controllers\CountryController;
use Modules\Location\Http\Controllers\CityController;

/*
|--------------------------------------------------------------------------
| Location Module Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin-dashboard')->name('location::admin.')->middleware(['web', 'auth'])->group(function () {
    
    // Country Management Routes
    Route::prefix('countries')->name('countries.')->group(function () {
        Route::get('/', [CountryController::class, 'index'])->name('index');
        Route::post('/json', [CountryController::class, 'indexJson'])->name('json');
        Route::get('/create', [CountryController::class, 'create'])->name('create');
        Route::post('/', [CountryController::class, 'store'])->name('store');
        Route::get('/{country}', [CountryController::class, 'show'])->name('show');
        Route::get('/{country}/edit', [CountryController::class, 'edit'])->name('edit');
        Route::put('/{country}', [CountryController::class, 'update'])->name('update');
        Route::delete('/{country}', [CountryController::class, 'destroy'])->name('destroy');
    });

    // City Management Routes
    Route::prefix('cities')->name('cities.')->group(function () {
        Route::get('/', [CityController::class, 'index'])->name('index');
        Route::post('/json', [CityController::class, 'indexJson'])->name('json');
        Route::get('/create', [CityController::class, 'create'])->name('create');
        Route::post('/', [CityController::class, 'store'])->name('store');
        Route::get('/{city}', [CityController::class, 'show'])->name('show');
        Route::get('/{city}/edit', [CityController::class, 'edit'])->name('edit');
        Route::put('/{city}', [CityController::class, 'update'])->name('update');
        Route::delete('/{city}', [CityController::class, 'destroy'])->name('destroy');
    });
});
