<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminMaintenanceProjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

// Language Switcher
Route::get('/lang/{locale}', [LanguageController::class, 'switchLanguage'])->name('lang.switch');

// Public Storefront Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Maintenance Projects & Case Studies Routes
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

// Product Catalog Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{category_slug}/{product_slug}', [ProductController::class, 'show'])->name('products.show');

// Services Routes
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

// Quote Cart & RFQ Workflow Routes
Route::get('/request-quote', [QuoteController::class, 'index'])->name('quote.index');
Route::post('/quote/add', [QuoteController::class, 'add'])->name('quote.add');
Route::post('/quote/direct', [QuoteController::class, 'directOrder'])->name('quote.direct');
Route::post('/quote/update', [QuoteController::class, 'update'])->name('quote.update');
Route::post('/quote/remove/{id}', [QuoteController::class, 'remove'])->name('quote.remove');
Route::post('/quote/store', [QuoteController::class, 'store'])->name('quote.store');
Route::get('/quote/success/{quote_number}', [QuoteController::class, 'success'])->name('quote.success');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Customer Dashboard
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('customer.dashboard')->middleware('auth');

// Admin Panel Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // RFQs
    Route::get('/quotes', [AdminController::class, 'quotes'])->name('quotes.index');
    Route::get('/quotes/{id}', [AdminController::class, 'showQuote'])->name('quotes.show');
    Route::post('/quotes/{id}/update', [AdminController::class, 'updateQuoteStatus'])->name('quotes.update');
    Route::post('/quotes/{id}/convert', [AdminController::class, 'convertQuoteToOrder'])->name('quotes.convert');
    Route::get('/quotes/{id}/print', [AdminController::class, 'printQuotePdf'])->name('quotes.print');

    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{id}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::post('/orders/{id}/update-items', [AdminController::class, 'updateOrderItems'])->name('orders.update-items');
    Route::post('/orders/{id}/items/add', [AdminController::class, 'addOrderItem'])->name('orders.items.add');
    Route::delete('/orders/{id}/items/{itemId}/delete', [AdminController::class, 'deleteOrderItem'])->name('orders.items.delete');
    Route::post('/orders/{id}/complete-sale', [AdminController::class, 'completeOrderSale'])->name('orders.complete-sale');

    // Categories Management
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
    Route::post('/categories/store', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::post('/categories/{id}/update', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{id}/delete', [AdminController::class, 'deleteCategory'])->name('categories.delete');

    // Maintenance Projects / Cases Management
    Route::get('/projects', [AdminMaintenanceProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [AdminMaintenanceProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects/store', [AdminMaintenanceProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{id}/edit', [AdminMaintenanceProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{id}/update', [AdminMaintenanceProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{id}/delete', [AdminMaintenanceProjectController::class, 'destroy'])->name('projects.destroy');

    // Products
    Route::get('/products', [AdminController::class, 'products'])->name('products.index');
    Route::post('/products/store', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::post('/products/{id}/update', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}/delete', [AdminController::class, 'deleteProduct'])->name('products.delete');

    // Home Page CMS Management
    Route::get('/cms', [AdminController::class, 'cms'])->name('cms.index');
    Route::post('/cms', [AdminController::class, 'updateCms'])->name('cms.update');

    // Site Branding, Colors & Social Media Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings.index');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

    // Branch Management
    Route::get('/branches', [AdminController::class, 'branches'])->name('branches.index');
    Route::post('/branches', [AdminController::class, 'storeBranch'])->name('branches.store');
    Route::post('/branches/{id}/update', [AdminController::class, 'updateBranch'])->name('branches.update');
    Route::delete('/branches/{id}/delete', [AdminController::class, 'deleteBranch'])->name('branches.delete');

    // Customers Management
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers.index');
    Route::post('/customers', [AdminController::class, 'storeCustomer'])->name('customers.store');

    // System Maintenance Tools for Hosting/Production
    Route::post('/tools/clear-cache', [AdminController::class, 'clearCache'])->name('tools.clear-cache');
    Route::post('/tools/storage-link', [AdminController::class, 'linkStorage'])->name('tools.storage-link');

    // Direct Sales / POS Redirect to Unified Orders & Sales Management
    Route::redirect('/sales/create', '/admin/orders')->name('sales.create');
});
