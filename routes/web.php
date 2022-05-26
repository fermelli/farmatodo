<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    // ROLES
    Route::get('/roles/management', RoleViewController::class)->name('roles.management');
    Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
    Route::get('/users/roles', [RoleUserController::class, 'index'])->name('users.roles');
    Route::post('users/{user}/roles/{role}', [RoleUserController::class, 'store'])->name('users.roles.store');
    Route::delete('users/{user}/roles/{role}', [RoleUserController::class, 'destroy'])->name('users.roles.delete');
});

require __DIR__ . '/auth.php';
