<?php

use Illuminate\Support\Facades\Route;
use Modules\Option\Http\Controllers\OptionController;

// Admin Dashboard Routes for Options
Route::prefix('dashboard')->middleware(['web', 'auth', 'role.access:developer,admin,employee,accounts'])->name('option::admin.')->group(function () {
    Route::prefix('options')->name('options.')->group(function () {
        Route::get('/', [OptionController::class, 'index'])->name('index');
        Route::post('/json', [OptionController::class, 'indexJson'])->name('json');
        Route::get('/create', [OptionController::class, 'create'])->name('create');
        Route::post('/', [OptionController::class, 'store'])->name('store');
        Route::get('/{option}', [OptionController::class, 'show'])->name('show');
        Route::get('/{option}/edit', [OptionController::class, 'edit'])->name('edit');
        Route::put('/{option}', [OptionController::class, 'update'])->name('update');
        Route::delete('/{option}', [OptionController::class, 'destroy'])->name('destroy');
    });
});
