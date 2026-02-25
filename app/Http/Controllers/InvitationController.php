<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ColocationInviteMail;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    public function send(Request $request, Colocation $colocation)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        if (Auth::id() !== $colocation->owner_id) {
            return back()->with('error', 'Unauthorized. Only the ledger owner can invite members.');
        }

        $exists = Invitation::where('colocation_id', $colocation->id)
            ->where('email', $request->email)
            ->where('accepted', false)
            ->where('expires_at', '>', now())
            ->exists();

        if ($exists) {
            return back()->with('error', 'A pending invitation already exists for this email.');
        }

        $invitation = Invitation::create([
            'colocation_id' => $colocation->id,
            'inviter_id' => Auth::id(),
            'email' => $request->email,
            'token' => Str::random(40),
            'expires_at' => now()->addDays(2),
        ]);

        Mail::to($request->email)->send(new ColocationInviteMail($invitation));

        return back()->with('success', 'Invitation sent successfully.');
    }

    public function accept($token)
    {
        $invitation = Invitation::where('token', $token)
            ->where('accepted', false)
            ->firstOrFail();

        if ($invitation->expires_at->isPast()) {
            return redirect()->route('login')->with('error', 'This invitation link has expired.');
        }

        if (!Auth::check()) {
            session(['pending_invite_token' => $token]);
            return redirect()->route('register')
                ->with('status', 'Please create an account to accept your invitation.');
        }

        if (Auth::user()->hasColocation()) {
            return redirect()->route('dashboard')->with('error', 'You are already an active member of a colocation.');
        }

        $colocation = $invitation->colocation;
        $colocation->users()->attach(Auth::id(), ['role' => 'member']);
        
        $invitation->update(['accepted' => true]);

        return redirect()->route('dashboard')->with('success', 'Welcome to ' . $colocation->name . '!');
    }
}