<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expense;
use App\Models\Settlement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function store(Request $request, Colocation $colocation) 
{
    $request->validate([
        'description' => 'required|string|max:255',
        'amount'      => 'required|numeric|min:0.01',
        'category_id' => 'required|exists:categories,id',
        'spent_at'    => 'required|date|before_or_equal:today', // Added today or past rule
    ]);

    if(!$colocation->users->contains(Auth::id())) {
        abort(403, 'Unauthorized action.');  
    }

    $expense = Expense::create([
        'description'   => $request->description,
        'amount'        => $request->amount,
        'spent_at'      => $request->spent_at,
        'user_id'       => Auth::id(), 
        'colocation_id' => $colocation->id,
        'category_id'   => $request->category_id,
    ]);

    $members = $colocation->users()->wherePivot('left_at', null)->get();
    $memberCount = $members->count();

    if ($memberCount > 1) {
        $shareAmount = $expense->amount / $memberCount;

        foreach ($members as $member) {
            if ($member->id !== Auth::id()) {
                Settlement::create([
                    'expense_id' => $expense->id,
                    'user_id'    => $member->id,
                    'amount'     => $shareAmount,
                    'is_paid'    => false,
                ]);
            }
        }
    }

    return back()->with('success', 'Expense logged and debts calculated!');
}

    public function destroy(Expense $expense)
    {
        $colocation = $expense->colocation;

        if (Auth::id() !== $expense->user_id && Auth::id() !== $colocation->owner_id) {
            abort(403, 'You are not authorized to delete this expense.');
        }

        $expense->delete();

        return back()->with('success', 'Expense deleted successfully!');
    }
}