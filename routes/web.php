<?php

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

// Protected Routes
Route::middleware(['auth', 'verified', 'check.banned'])->group(function () {
    
    Route::get('/dashboard', function () {
        $users = [];
        if (auth()->user()->global_role === 'admin') {
            $users = User::where('id', '!=', auth()->id())->get();
        }
        return view('dashboard', compact('users'));
    })->name('dashboard');

    Route::post('/admin/users/{user}/toggle-ban', function (User $user) {
        if (auth()->user()->global_role !== 'admin') {
            abort(403);
        }
        
        $user->update([
            'is_banned' => !$user->is_banned
        ]);

        return back()->with('status', 'User status updated successfully.');
    })->name('admin.users.toggle-ban');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';