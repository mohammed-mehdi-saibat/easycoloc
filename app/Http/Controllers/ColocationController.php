<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pendingInvites = Invitation::where('email', $user->email)
            ->where('accepted', false)
            ->where('expires_at', '>', now())
            ->with('colocation') 
            ->get();

        $activeColocation = $user->activeColocation();

        $users = [];
        if($user->global_role === 'admin') {
            $users = User::where('id', '!=', $user->id)->get();
        }


        return view('dashboard', compact('pendingInvites', 'activeColocation', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if (Auth::user()->hasColocation()) {
            return back()->with('error', 'You are already a member of a group!');
        }

        $colocation = Colocation::create([
            'name' => $request->name,
            'description' => $request->description,
            'owner_id' => Auth::id(),
        ]);

        $colocation->users()->attach(Auth::id(), ['role' => 'owner']);

        return redirect()->route('dashboard')->with('success', 'Group created successfully!');
    }
}