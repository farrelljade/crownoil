<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProspectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTargetController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (auth()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('login');
    }
});
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::get('/dashboard/user/{id}', [DashboardController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.user');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('prospects', ProspectController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('users', UserController::class);
    Route::get('/user-targets', [UserTargetController::class, 'index'])->name('user-targets.index');
    Route::post('/user-targets', [UserTargetController::class, 'store'])->name('user-targets.store');
    Route::post('/prospects/reassign', [ProspectController::class, 'reassign'])->name('prospects.reassign');

    Route::get('/orders/{id}/details', [OrderController::class, 'getOrderDetails'])->name('orders.details');
});

require __DIR__.'/auth.php';
