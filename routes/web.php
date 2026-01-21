<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PIMController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\RecruitmentController;
use App\Http\Controllers\MyInfoController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\BuzzController;

Route::get('/', [LoginController::class, 'show'])->name('login');

Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Maintenance routes (requires main auth, then maintenance auth)
Route::middleware('auth.session')->group(function () {
    Route::get('/maintenance/auth', [MaintenanceController::class, 'showAuth'])->name('maintenance.auth');
    Route::post('/maintenance/auth', [MaintenanceController::class, 'authenticate'])->name('maintenance.auth.post');
    
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::get('/maintenance/purge-employee', [MaintenanceController::class, 'purgeEmployee'])->name('maintenance.purge-employee');
    Route::get('/maintenance/purge-candidate', [MaintenanceController::class, 'purgeCandidate'])->name('maintenance.purge-candidate');
    Route::get('/maintenance/access-records', [MaintenanceController::class, 'accessRecords'])->name('maintenance.access-records');
});

Route::middleware('auth.session')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::get('/pim', [PIMController::class, 'index'])->name('pim');
    Route::get('/leave', [LeaveController::class, 'index'])->name('leave');
    Route::get('/time', [TimeController::class, 'index'])->name('time');
    Route::get('/recruitment', [RecruitmentController::class, 'index'])->name('recruitment');
    Route::get('/my-info', [MyInfoController::class, 'index'])->name('myinfo');
    Route::get('/performance', [PerformanceController::class, 'index'])->name('performance');
    Route::get('/directory', [DirectoryController::class, 'index'])->name('directory');
    Route::get('/claim', [ClaimController::class, 'index'])->name('claim');
    Route::get('/buzz', [BuzzController::class, 'index'])->name('buzz');
});
