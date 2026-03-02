<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ColocationInviteMail;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    public function send(Request $request, Colocation $colocation)
    {
        $request->validate(['email' => 'required|email']);

        if (Auth::id() !== $colocation->owner_id) {
            return back()->with('error', 'Unauthorized. Only the owner can invite.');
        }

        $exists = Invitation::where('colocation_id', $colocation->id)
            ->where('email', $request->email)
            ->where('accepted', false)
            ->exists();

        if ($exists) {
            return back()->with('error', 'A pending invitation already exists.');
        }

        $invitation = Invitation::create([
            'colocation_id' => $colocation->id,
            'inviter_id' => Auth::id(),
            'email' => $request->email,
            'token' => Str::random(40),
            'expires_at' => now()->addDays(2),
        ]);

        try {
            Mail::to($request->email)->send(new ColocationInviteMail($invitation));
        } catch (\Exception $e) {
        }

        return back()->with('success', 'Invitation recorded! (Check DB for token if mail fails)');
    }

    public function accept($token)
    {
        $invitation = Invitation::where('token', $token)
            ->where('accepted', false)
            ->firstOrFail();

        if ($invitation->expires_at->isPast()) {
            return redirect()->route('dashboard')->with('error', 'Invite expired.');
        }

        if (!Auth::check()) {
            return redirect()->route('register')->with('status', 'Register to accept invite.');
        }

        if (Auth::user()->activeColocation()) {
            return redirect()->route('dashboard')->with('error', 'You already have a group.');
        }

        $invitation->colocation->users()->attach(Auth::id(), ['role' => 'member']);
        $invitation->update(['accepted' => true]);

        return redirect()->route('dashboard')->with('success', 'Joined group!');
    }
}