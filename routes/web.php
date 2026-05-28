<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicPortalController;
use App\Http\Controllers\Admin\AdminCommandController;

// Public Portal Dual Interface A
Route::get('/', [PublicPortalController::class, 'explore'])->name('public.explore');
Route::get('/krisis/{id}', [PublicPortalController::class, 'showContract'])->name('public.contract.show');
Route::post('/krisis/{id}/donate', [PublicPortalController::class, 'donate'])->name('public.contract.donate');
Route::post('/krisis/{id}/success', [PublicPortalController::class, 'paymentSuccess'])->name('public.contract.success');

use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Command Center Interface B
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
     Route::get('/', [AdminCommandController::class, 'index'])->name('dashboard');
     Route::get('/analytics', [AdminCommandController::class, 'analyticsDashboard'])->name('analytics');
     Route::get('/telemetry', [AdminCommandController::class, 'telemetryLogs'])->name('telemetry');
     Route::get('/donations', [AdminCommandController::class, 'donations'])->name('donations');
     Route::get('/contracts/{id}', [AdminCommandController::class, 'showContract'])->name('contracts.show');
     Route::post('/contracts/{id}/start', [AdminCommandController::class, 'startCrowdfunding'])->name('contracts.start');
});
