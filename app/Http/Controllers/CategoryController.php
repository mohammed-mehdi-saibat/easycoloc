<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $activeColocation = $user->activeColocation();

        if (!$activeColocation || $activeColocation->pivot->role !== 'owner') {
            return back()->with('error', 'Only the group owner can add categories.');
        }

        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        Category::create([
            'name' => $request->name,
            'colocation_id' => $activeColocation->id
        ]);

        return back()->with('success', 'New category added to your group!');
    }
}