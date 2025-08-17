<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeletedItemsController;
use App\Http\Controllers\Admin\OwnerController;
use App\Http\Controllers\Admin\PendingChangeController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\SoldProductController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Admin prefix routes
Route::prefix('admin')->name('admin.')->middleware(['web', 'prevent.back.after.logout'])->group(function () {

    // --- Authentication Routes ---
    // Routes for guests (not logged in). The 'guest' middleware redirects them if they are already logged in.
    Route::middleware('guest:web')->group(function () {
        Route::get('login', [AdminController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminController::class, 'login'])->name('login.submit');
    });

    // Logout route for authenticated users
    Route::post('logout', [AdminController::class, 'logout'])->name('logout');
    
    // Session management routes
    Route::middleware(['auth:web'])->group(function () {
        Route::get('session/check', [AdminController::class, 'checkSession'])->name('session.check');
        Route::post('session/extend', [AdminController::class, 'extendSession'])->name('session.extend');
    });
    // --- End Authentication Routes ---


    // Public product-details route (must be outside protected middleware group)
    Route::get('owners/product-details', [OwnerController::class, 'productDetails'])->name('owners.product-details');

    // --- Protected Admin Routes ---
    // All routes in this group require the user to be authenticated and have the correct permissions.
    Route::middleware(['auth:web', 'secure.session', 'prevent.back.history', 'employee.permission'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/realtime', [DashboardController::class, 'getRealTimeData'])->name('dashboard.realtime');
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        // Users management
        Route::resource('users', UserController::class);
        Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

        // Products management
        Route::resource('products', ProductController::class);

        // Product Categories management
        Route::resource('product-categories', ProductCategoryController::class);

        // Contact Messages management
        Route::resource('contact-messages', ContactMessageController::class);
        Route::patch('contact-messages/{contactMessage}/mark-read', [ContactMessageController::class, 'markAsRead'])->name('contact-messages.mark-read');

        // Owners management
        Route::resource('owners', OwnerController::class);

        // Sold Products management
        Route::resource('sold-products', SoldProductController::class);
        Route::post('sold-products/{soldProduct}/void-warranty', [SoldProductController::class, 'voidWarranty'])->name('sold-products.void-warranty');

        // Pending Changes management (Admin only)
        Route::prefix('pending-changes')->name('pending-changes.')->group(function () {
            Route::get('/', [PendingChangeController::class, 'index'])->name('index');
            Route::get('/{pendingChange}', [PendingChangeController::class, 'show'])->name('show');
            Route::post('/{pendingChange}/approve', [PendingChangeController::class, 'approve'])->name('approve');
            Route::post('/{pendingChange}/reject', [PendingChangeController::class, 'reject'])->name('reject');
            Route::get('/history/all', [PendingChangeController::class, 'history'])->name('history');
        });

        // Audit Logs management
        Route::get('audit-logs/dashboard', [AuditLogController::class, 'dashboard'])->name('audit-logs.dashboard');
        Route::get('audit-logs/realtime', [AuditLogController::class, 'realtime'])->name('audit-logs.realtime');
        Route::get('audit-logs/export', [AuditLogController::class, 'export'])->name('audit-logs.export');
        Route::resource('audit-logs', AuditLogController::class);

        // Deleted Items management
        Route::prefix('deleted-items')->name('deleted-items.')->group(function () {
            Route::get('/', [DeletedItemsController::class, 'index'])->name('index');
            Route::post('/restore/{type}/{id}', [DeletedItemsController::class, 'restore'])->name('restore');
            Route::delete('/force-delete/{type}/{id}', [DeletedItemsController::class, 'forceDelete'])->name('force-delete');
            Route::post('/bulk-restore', [DeletedItemsController::class, 'bulkRestore'])->name('bulk-restore');
            Route::post('/bulk-delete', [DeletedItemsController::class, 'bulkDelete'])->name('bulk-delete');
            Route::post('/bulk-force-delete', [DeletedItemsController::class, 'bulkForceDelete'])->name('bulk-force-delete');
            Route::post('/restore-all', [DeletedItemsController::class, 'restoreAll'])->name('restore-all');
            Route::delete('/clean-old', [DeletedItemsController::class, 'cleanOldItems'])->name('clean-old');
            Route::delete('/empty-trash', [DeletedItemsController::class, 'emptyTrash'])->name('empty-trash');
        });

        // Reports management (Admin/CEO only)
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [ReportsController::class, 'index'])->name('index');
            Route::get('/comprehensive', [ReportsController::class, 'downloadComprehensiveReport'])->name('comprehensive');
            Route::get('/owners', [ReportsController::class, 'downloadOwnersReport'])->name('owners');
            Route::get('/sales', [ReportsController::class, 'downloadSalesReport'])->name('sales');
            Route::get('/warranty', [ReportsController::class, 'downloadWarrantyReport'])->name('warranty');
            Route::get('/warranty-data', [ReportsController::class, 'getWarrantyDataForPDF'])->name('warranty-data');
        });

    });
    // --- End Protected Admin Routes ---


});
// End of admin routes
