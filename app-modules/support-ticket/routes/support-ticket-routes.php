<?php

use Modules\SupportTicket\Http\Controllers\Admin\SupportTicketController as AdminSupportTicketController;
use Modules\SupportTicket\Http\Controllers\Admin\SupportTicketMessageController as AdminSupportTicketMessageController;
use Modules\SupportTicket\Http\Controllers\SupportTicketController;
use Modules\SupportTicket\Http\Controllers\SupportTicketMessageController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Admin Routes
Route::prefix('admin-dashboard')->name('support-ticket::admin.')->middleware(['web', 'auth', 'role.access:developer,admin,employee'])->group(function () {
    
    // Support Ticket Management Routes
    Route::prefix('support-tickets')->name('tickets.')->group(function () {
        Route::get('/', [AdminSupportTicketController::class, 'index'])->name('index');
        Route::get('/json', [AdminSupportTicketController::class, 'indexJson'])->name('json');
        Route::get('/stats', [AdminSupportTicketController::class, 'getStats'])->name('stats');
        Route::get('/{ticket}', [AdminSupportTicketController::class, 'show'])->name('show');
        Route::get('/{ticket}/edit', [AdminSupportTicketController::class, 'edit'])->name('edit');
        Route::put('/{ticket}', [AdminSupportTicketController::class, 'update'])->name('update');
        // Ticket deletion disabled for audit trail integrity
        // Route::delete('/{ticket}', [AdminSupportTicketController::class, 'destroy'])->name('destroy');
        Route::post('/{ticket}/assign-to-me', [AdminSupportTicketController::class, 'assignToMe'])->name('assign-to-me');
        Route::post('/bulk-update', [AdminSupportTicketController::class, 'bulkUpdate'])->name('bulk-update');
        
        // Message Routes for Admin
        Route::prefix('{ticket}/messages')->name('messages.')->group(function () {
            Route::post('/', [AdminSupportTicketMessageController::class, 'store'])->name('store');
            Route::get('/', [AdminSupportTicketMessageController::class, 'getMessages'])->name('index');
            Route::put('/{message}', [AdminSupportTicketMessageController::class, 'update'])->name('update');
            Route::delete('/{message}', [AdminSupportTicketMessageController::class, 'destroy'])->name('destroy');
            Route::post('/quick-reply', [AdminSupportTicketMessageController::class, 'quickReply'])->name('quick-reply');
            Route::post('/{message}/toggle-visibility', [AdminSupportTicketMessageController::class, 'toggleVisibility'])->name('toggle-visibility');
            Route::post('/mark-as-read', [AdminSupportTicketMessageController::class, 'markAsRead'])->name('mark-as-read');
            Route::get('/stats', [AdminSupportTicketMessageController::class, 'getStats'])->name('stats');
        });
    });
});

// Customer Routes (Localized)
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function() {
    Route::middleware(['auth', 'verified.email_or_mobile'])->group(function () {
        
        // Support Ticket routes
        Route::prefix('accounts/support-tickets')->name('support-ticket::tickets.')->group(function () {
            Route::get('/', [SupportTicketController::class, 'index'])->name('index');
            Route::get('/create', [SupportTicketController::class, 'create'])->name('create');
            Route::post('/', [SupportTicketController::class, 'store'])->name('store');
            Route::get('/search', [SupportTicketController::class, 'search'])->name('search');
            Route::get('/export', [SupportTicketController::class, 'export'])->name('export');
            Route::get('/stats', [SupportTicketController::class, 'getStats'])->name('stats');
            Route::get('/recent', [SupportTicketController::class, 'getRecentTickets'])->name('recent');
            Route::get('/{ticket}', [SupportTicketController::class, 'show'])->name('show');
            Route::post('/{ticket}/close', [SupportTicketController::class, 'close'])->name('close');
            Route::post('/{ticket}/reopen', [SupportTicketController::class, 'reopen'])->name('reopen');
            Route::post('/{ticket}/rate', [SupportTicketController::class, 'rate'])->name('rate');
            
            // Message Routes for Customer
            Route::prefix('{ticket}/messages')->name('messages.')->group(function () {
                Route::post('/', [SupportTicketMessageController::class, 'store'])->name('store');
                Route::get('/', [SupportTicketMessageController::class, 'getMessages'])->name('index');
                // Removed update and destroy routes - customers cannot edit/delete messages
                // Removed draft routes - no draft functionality needed
                Route::post('/upload-attachment', [SupportTicketMessageController::class, 'uploadAttachment'])->name('upload-attachment');
                Route::get('/conversation-stats', [SupportTicketMessageController::class, 'getConversationStats'])->name('conversation-stats');
            });
            
            Route::post('/{ticket}/mark-as-resolved', [SupportTicketMessageController::class, 'markAsResolved'])->name('mark-as-resolved');
        });
    });
});
