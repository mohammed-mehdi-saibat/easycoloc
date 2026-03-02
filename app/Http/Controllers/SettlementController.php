<?php

namespace App\Http\Controllers;

use App\Models\Settlement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettlementController extends Controller
{
    public function markAsPaid(Settlement $settlement)
    {
        $expense = $settlement->expense;
        $colocation = $expense->colocation;

        $isOwner = Auth::id() === $colocation->owner_id;
        $isCreator = Auth::id() === $expense->user_id;

        if (!$isOwner && !$isCreator) {
            abort(403, 'Only the owner or the expense creator can confirm payments.');
        }

        if (!$settlement->is_paid) {
            $settlement->update(['is_paid' => true]);
            $settlement->user->increment('reputation');
        }

        return back()->with('success', 'Payment confirmed! Reputation awarded.');
    }
}