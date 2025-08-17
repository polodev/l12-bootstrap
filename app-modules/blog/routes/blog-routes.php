<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\BlogController;
use Modules\Blog\Http\Controllers\BlogFrontendController;
use Modules\Blog\Http\Controllers\TagController;

// Admin Routes (No localization - admin/dashboard only)
Route::prefix('admin-dashboard')->name('blog::admin.')->middleware(['web', 'auth', 'role.access:developer,admin,employee,accounts'])->group(function () {
    
    // Blog Management Routes
    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::post('/json', [BlogController::class, 'indexJson'])->name('json');
        
        Route::get('/create', [BlogController::class, 'create'])->name('create');
        Route::post('/', [BlogController::class, 'store'])->name('store');
        
        Route::get('/{blog}', [BlogController::class, 'show'])->name('show');
        Route::get('/{blog}/edit', [BlogController::class, 'edit'])->name('edit');
        Route::put('/{blog}', [BlogController::class, 'update'])->name('update');
        Route::delete('/{blog}', [BlogController::class, 'destroy'])->name('destroy');
    });
    
    // Tag Management Routes
    Route::prefix('tags')->name('tags.')->group(function () {
        Route::get('/', [TagController::class, 'index'])->name('index');
        Route::post('/json', [TagController::class, 'indexJson'])->name('json');
        
        Route::get('/create', [TagController::class, 'create'])->name('create');
        Route::post('/', [TagController::class, 'store'])->name('store');
        
        Route::get('/{slug}', [TagController::class, 'show'])->name('show');
        Route::get('/{slug}/edit', [TagController::class, 'edit'])->name('edit');
        Route::put('/{slug}', [TagController::class, 'update'])->name('update');
        Route::delete('/{slug}', [TagController::class, 'destroy'])->name('destroy');
    });
});

// Frontend Routes (With localization support)
Route::group([
    'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(),
    'middleware' => ['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    'as' => 'blog::'
], function() {
    
    // Blog Frontend Routes
    Route::get('/blogs', [BlogFrontendController::class, 'index'])->name('blog.index');
    Route::get('/blogs/{blog}', [BlogFrontendController::class, 'show'])->name('blog.show');
    
    // Tag Frontend Routes
    Route::get('/blog-tags', [BlogFrontendController::class, 'tags'])->name('blog.tags');
    Route::get('/blog-tags/{slug}', [BlogFrontendController::class, 'tagShow'])->name('blog.tags.show');
    
    // Alternative route for blogs by tag
    Route::get('/blogs/tag/{tag}', [BlogFrontendController::class, 'blogsByTag'])->name('blog.by-tag');
});
