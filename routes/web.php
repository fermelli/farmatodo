<?php

use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\Products\ProductPurchaseController;
use App\Http\Controllers\Products\ProductSearchController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Roles\RoleUserController;
use App\Http\Controllers\Roles\RoleViewController;
use App\Http\Controllers\Roles\RolesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ProductSearchController::class, 'index'])->name('landing');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'verified', 'can:is-super-administrator'])->group(function () {
    // ROLES
    Route::get('/roles/management', RoleViewController::class)->name('roles.management');
    Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
    Route::get('/users/roles', [RoleUserController::class, 'index'])->name('users.roles');
    Route::post('users/{user}/roles/{role}', [RoleUserController::class, 'store'])->name('users.roles.store');
    Route::delete('users/{user}/roles/{role}', [RoleUserController::class, 'destroy'])->name('users.roles.delete');
});

//PRODUCTS
Route::resource('products', ProductController::class)
    ->middleware(['auth', 'verified', 'can:is-super-administrator-or-administrator']);

Route::get('/product-search', [ProductSearchController::class, 'search'])->name('product-search');

// PURCHASES
Route::get('purchases', [ProductPurchaseController::class, 'index'])->name('purchases');

Route::middleware(['auth', 'verified', 'can:is-user'])->group(function () {
    Route::post('purchases/store', [ProductPurchaseController::class, 'store'])
        ->name('purchases.store');
    Route::get('purchases/show/{purchase}', [ProductPurchaseController::class, 'show'])
        ->middleware('can:show-purchase,purchase')
        ->name('purchases.show');
    Route::get('purchases/all', [ProductPurchaseController::class, 'all'])
        ->name('purchases.all');
});

// Report

Route::get('report', [ReportController::class, 'index'])
    ->middleware(['auth', 'verified', 'can:is-super-administrator-or-administrator'])
    ->name('report');

require __DIR__ . '/auth.php';
