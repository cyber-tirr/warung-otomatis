<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\ReportController;

// Halaman pelanggan (public)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Order routes - DISABLED: Pelanggan tidak bisa membuat pesanan sendiri
// Pesanan hanya bisa dibuat oleh admin/operator melalui admin panel
// Route::post('/order', [OrderController::class, 'store'])->name('order.store');
// Route::get('/payment/{order}', [OrderController::class, 'showPayment'])->name('payment.show');
// Route::post('/payment/callback', [OrderController::class, 'paymentCallback'])->name('payment.callback');

// Cart routes (public - untuk localStorage sync jika diperlukan)
Route::get('/cart', [CartController::class, 'getCart'])->name('cart.get');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard (Admin & Operator)
Route::middleware(['auth.custom'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin Only Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);
    });
    
    // Admin & Operator Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('orders', AdminOrderController::class)->except(['edit', 'update']);
        Route::post('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
        Route::get('orders/{order}/payment-confirmation', [AdminOrderController::class, 'paymentConfirmation'])->name('orders.payment-confirmation');
        Route::post('orders/{order}/process-payment', [AdminOrderController::class, 'processPayment'])->name('orders.process-payment');
        Route::get('orders/{order}/receipt', [AdminOrderController::class, 'receipt'])->name('orders.receipt');
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
        Route::get('reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
    });
});
