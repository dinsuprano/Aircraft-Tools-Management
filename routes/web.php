<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Tools Management
    Route::get('tools/{tool}/print', [ToolController::class, 'printBarcode'])->name('tools.print');
    Route::resource('tools', ToolController::class);

    // Employee Management
    Route::resource('employees', \App\Http\Controllers\EmployeeController::class);

    // Maintenance Management
    Route::resource('maintenance', \App\Http\Controllers\MaintenanceController::class);

    // Check In / Check Out
    Route::resource('borrows', \App\Http\Controllers\BorrowController::class);

    // Admin Only Control Panel
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('employee-admins', [\App\Http\Controllers\Admin\EmployeeAdminController::class, 'index'])->name('employee-admins.index');
        Route::patch('employee-admins/{user}/toggle', [\App\Http\Controllers\Admin\EmployeeAdminController::class, 'toggleApproval'])->name('employee-admins.toggle');
        Route::delete('employee-admins/{user}', [\App\Http\Controllers\Admin\EmployeeAdminController::class, 'destroy'])->name('employee-admins.destroy');
    });
});

require __DIR__.'/auth.php';
