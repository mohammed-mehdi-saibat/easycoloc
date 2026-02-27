<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\InvitationController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', 'check.banned'])->group(function () {
    
    // Unified Dashboard
    Route::get('/dashboard', [ColocationController::class, 'index'])->name('dashboard');

    // Colocation Actions
    Route::post('/colocations', [ColocationController::class, 'store'])->name('colocations.store');
    
    // Invitation Actions
    Route::post('/colocations/{colocation}/invite', [InvitationController::class, 'send'])->name('invitations.send');
    Route::get('/invitations/accept/{token}', [InvitationController::class, 'accept'])->name('invitations.accept');

    // Admin Actions
    Route::post('/admin/users/{user}/toggle-ban', function (User $user) {
        if (auth()->user()->global_role !== 'admin') abort(403);
        $user->update(['is_banned' => !$user->is_banned]);
        return back()->with('status', 'User status updated successfully.');
    })->name('admin.users.toggle-ban');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';