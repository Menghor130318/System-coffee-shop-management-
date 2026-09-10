<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerFrontController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ReportController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public / landing routes
Route::get('/', function () {
    return view('pages.auth.login');
});

// Admin-only routes (only Admin can access)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function (\App\Services\DashboardService $dashboardService) {
        return view('admin.dashboard', $dashboardService->overview());
    })->name('admin.dashboard');

    Route::resource('user', UserController::class);
    Route::resource('category', CategoryController::class);
    Route::post('/category/migrate-products', [CategoryController::class, 'migrateProducts'])->name('category.migrate-products');
    Route::resource('product', ProductController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('reservation', ReservationController::class);
    Route::resource('order', OrderController::class);
    Route::resource('employee', EmployeeController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('inventory', InventoryController::class);
    Route::resource('discount', DiscountController::class);

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

// Authenticated user routes (dashboard home)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function (\App\Services\DashboardService $dashboardService) {
        if (auth()->user() && strtolower(auth()->user()->role?->name ?? '') === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.dashboard', $dashboardService->overview());
    })->name('dashboard');

    Route::get('home', function (\App\Services\DashboardService $dashboardService) {
        if (auth()->user() && strtolower(auth()->user()->role?->name ?? '') === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.dashboard', $dashboardService->overview());
    })->name('home');
});

// Public customer-facing routes
Route::get('/dashboard-customer', [CustomerFrontController::class, 'customerDashboard'])->name('customer.dashboard');
Route::get('/menu', [CustomerFrontController::class, 'menu'])->name('menu');
Route::get('/reservation', [CustomerFrontController::class, 'reservation'])->name('reservation.public');
Route::post('/reservation', [CustomerFrontController::class, 'storeReservation'])->name('reservation.public.store');
Route::resource('product', ProductController::class);
// Authenticated customer routes
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CustomerFrontController::class, 'cart'])->name('cart.index');
    Route::post('/cart/add/{id}', [CustomerFrontController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{id}', [CustomerFrontController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CustomerFrontController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/checkout', [CustomerFrontController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/place-order', [CustomerFrontController::class, 'placeOrder'])->name('order.place');
    Route::get('/my-orders', [CustomerFrontController::class, 'myOrders'])->name('my.orders');
    Route::get('/my-orders/{order}/invoice', [CustomerFrontController::class, 'invoice'])->name('order.invoice');
    Route::get('/profile', [CustomerFrontController::class, 'profile'])->name('customer.profile');
    Route::post('/profile', [CustomerFrontController::class, 'updateProfile'])->name('customer.profile.update');
    
});
