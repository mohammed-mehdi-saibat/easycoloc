<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ColocationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', 'check.banned'])->group(function () {
    
    // Dashboard 
    Route::get('/dashboard', [ColocationController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Colocations (Groups)
    Route::post('/colocations', [ColocationController::class, 'store'])->name('colocations.store');
    
    // Invitations
    Route::post('/colocations/{colocation}/invite', [InvitationController::class, 'send'])->name('invitations.send');
    Route::get('/invitations/accept/{token}', [InvitationController::class, 'accept'])->name('invitations.accept');
});

require __DIR__.'/auth.php';