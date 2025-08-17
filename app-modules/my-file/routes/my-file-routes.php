<?php

use Illuminate\Support\Facades\Route;
use Modules\MyFile\Http\Controllers\MyFileController;

/*
|--------------------------------------------------------------------------
| My File Module Routes
|--------------------------------------------------------------------------
|
| Here are the routes for the my-file module following the admin dashboard
| naming convention pattern.
|
*/

Route::middleware(['web', 'auth', 'role.access:developer,admin,employee,accounts'])
    ->prefix('admin')
    ->name('my-file::')
    ->group(function () {
        
        // My Files CRUD routes
        Route::get('my-files', [MyFileController::class, 'index'])->name('index');
        Route::get('my-files/create', [MyFileController::class, 'create'])->name('create');
        Route::post('my-files', [MyFileController::class, 'store'])->name('store');
        Route::get('my-files/{myFile}', [MyFileController::class, 'show'])->name('show');
        Route::get('my-files/{myFile}/edit', [MyFileController::class, 'edit'])->name('edit');
        Route::put('my-files/{myFile}', [MyFileController::class, 'update'])->name('update');
        Route::delete('my-files/{myFile}', [MyFileController::class, 'destroy'])->name('destroy');
        
        // DataTable JSON endpoint
        Route::post('my-files-json', [MyFileController::class, 'indexJson'])->name('index_json');
        
        // Additional file operations
        Route::get('my-files/{myFile}/download', [MyFileController::class, 'download'])->name('download');
    });