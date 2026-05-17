<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;

Route::get('/', [AuthController::class, 'showLogin']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [ItemController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/item/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/admin/item/store', [ItemController::class, 'store'])->name('items.store');
    Route::get('/admin/item/{id}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/admin/item/{id}/update', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/admin/item/{id}/delete', [ItemController::class, 'destroy'])->name('items.destroy');
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/admin/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/admin/categories/{id}/delete', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('/checkout', [TransactionController::class, 'checkout'])->name('checkout');
    Route::get('/orders/history', [TransactionController::class, 'history'])->name('transactions.history');
});

Route::get('/catalog', [ItemController::class, 'userCatalog'])->name('user.catalog');

// Route khusus untuk User yang sudah Login (Akses katalog dan keranjang)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{itemId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.delete');
});
