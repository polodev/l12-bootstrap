<?php

use Illuminate\Support\Facades\Route;
use Modules\Documentation\Http\Controllers\DocumentationController;

/*
|--------------------------------------------------------------------------
| Documentation Routes
|--------------------------------------------------------------------------
|
| Here is where you can register documentation routes for your application.
| These routes are loaded by the DocumentationServiceProvider within a group which
| contains the "web" middleware group and admin authentication.
|
*/

Route::middleware(['web', 'auth', 'role.access:developer,admin,employee,accounts'])->prefix('dashboard/documentation')->name('documentation::admin.')->group(function () {
    // Documentation CRUD routes
    Route::get('/', [DocumentationController::class, 'index'])->name('index');
    Route::post('/json', [DocumentationController::class, 'indexJson'])->name('json');
    Route::get('/create', [DocumentationController::class, 'create'])->name('create');
    Route::post('/', [DocumentationController::class, 'store'])->name('store');
    Route::get('/{documentation}', [DocumentationController::class, 'show'])->name('show');
    Route::get('/{documentation}/edit', [DocumentationController::class, 'edit'])->name('edit');
    Route::put('/{documentation}', [DocumentationController::class, 'update'])->name('update');
    Route::delete('/{documentation}', [DocumentationController::class, 'destroy'])->name('destroy');
});