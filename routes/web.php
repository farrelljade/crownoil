<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProspectController;
use App\Http\Controllers\UserController;
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
Route::get('/dashboard', [DashboardController::class, 'index']) // Use the DashboardController
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('prospects', ProspectController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';
