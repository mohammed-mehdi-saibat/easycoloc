<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettlementController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', 'check.banned'])->group(function () {
    
    Route::get('/dashboard', [ColocationController::class, 'index'])->name('dashboard');

    Route::post('/colocations', [ColocationController::class, 'store'])->name('colocations.store');
    
    Route::post('/colocations/{colocation}/leave', [ColocationController::class, 'leave'])
        ->name('colocations.leave');
    Route::post('/colocations/{colocation}/remove-member/{member}', [ColocationController::class, 'removeMember'])
        ->name('colocations.remove-member');
    
    Route::post('/colocations/{colocation}/invite', [InvitationController::class, 'send'])->name('invitations.send');
    Route::get('/invitations/accept/{token}', [InvitationController::class, 'accept'])->name('invitations.accept');

    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

    Route::post('/settlements/{settlement}/confirm', [SettlementController::class, 'markAsPaid'])->name('settlements.confirm');

    Route::post('/admin/users/{user}/toggle-ban', function (User $user) {
        if (auth()->user()->global_role !== 'admin') abort(403);
        $user->update(['is_banned' => !$user->is_banned]);
        return back()->with('status', 'User status updated successfully.');
    })->name('admin.users.toggle-ban');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/colocation/{colocation}/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
});

require __DIR__.'/auth.php';