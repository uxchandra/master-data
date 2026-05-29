<?php

use App\Http\Controllers\Materials\ItemMaterialController;
use App\Http\Controllers\Materials\SupplierMaterialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagement\PermissionController;
use App\Http\Controllers\UserManagement\RoleController;
use App\Http\Controllers\UserManagement\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('materials')->name('materials.')->group(function () {
        Route::resource('suppliers', SupplierMaterialController::class)->except('show');
        Route::resource('items', ItemMaterialController::class)->except('show');
    });

    Route::prefix('user-management')->name('user-management.')->group(function () {
        Route::resource('users', UserController::class)->except('show');
        Route::resource('roles', RoleController::class)->except('show');
        Route::resource('permissions', PermissionController::class)->except('show');
    });
});

require __DIR__.'/auth.php';
