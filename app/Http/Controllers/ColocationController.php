<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Invitation;
use App\Models\User;
use App\Models\Colocation; 
use App\Models\Settlement;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $activeColocation = $user->activeColocation();
        
        $categories = collect();
        $expenses = collect();
        $totalSpent = 0;
        $pendingInvites = Invitation::where('email', $user->email)
            ->where('accepted', false)
            ->get();

        if ($activeColocation) {
            $categories = Category::whereNull('colocation_id')
                ->orWhere('colocation_id', $activeColocation->id)
                ->get();

            $totalSpent = $activeColocation->expenses()->sum('amount');

            $query = $activeColocation->expenses()->with(['payer', 'category', 'settlements.user']);

            if ($request->filled('month') && $request->month !== 'all') {
                $query->whereMonth('spent_at', $request->month);
            }

            if ($request->filled('category') && $request->category !== 'all') {
                $query->where('category_id', $request->category);
            }

            $expenses = $query->latest()->get();
            
            $members = $activeColocation->users;

            foreach ($members as $member) {
                $owedToThem = Settlement::whereHas('expense', function($query) use ($member, $activeColocation) {
                    $query->where('user_id', $member->id)
                          ->where('colocation_id', $activeColocation->id);
                })->where('is_paid', false)->sum('amount');

                $owedByThem = Settlement::where('user_id', $member->id)
                    ->whereHas('expense', function($query) use ($activeColocation) {
                        $query->where('colocation_id', $activeColocation->id);
                    })
                    ->where('is_paid', false)
                    ->sum('amount');

                $member->current_balance = $owedToThem - $owedByThem;
            }
        }

        $adminStats = null;
        $allColocations = collect();
        $latestGlobalExpenses = collect();

        if ($user->global_role === 'admin') {
            $adminStats = [
                'total_platform_spent' => Expense::sum('amount'),
                'total_users'          => User::count(),
                'total_groups'         => Colocation::count(),
                'top_spender'         => User::withSum('expenses', 'amount')
                                            ->orderByDesc('expenses_sum_amount')
                                            ->first(),
                'top_group'           => Colocation::withSum('expenses', 'amount')
                                            ->orderByDesc('expenses_sum_amount')
                                            ->first(),
            ];

            $allColocations = Colocation::withCount(['users' => function($q) {
                $q->whereNull('colocation_user.left_at');
            }])->withSum('expenses', 'amount')->get();

            $latestGlobalExpenses = Expense::with(['payer', 'colocation', 'category'])->latest()->take(5)->get();
        }

        $users = ($user->global_role === 'admin') 
            ? User::where('id', '!=', $user->id)->get() 
            : collect();

        return view('dashboard', compact(
            'activeColocation', 'categories', 'expenses', 'totalSpent', 
            'pendingInvites', 'users', 'adminStats', 'allColocations', 'latestGlobalExpenses'
        ));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string']);
        $colocation = Colocation::create(['name' => $request->name, 'description' => $request->description, 'owner_id' => Auth::id()]);
        $colocation->users()->attach(Auth::id(), ['role' => 'owner']);
        return redirect()->route('dashboard')->with('success', 'Colocation created successfully!');
    }

    public function leave(Colocation $colocation)
    {
        $user = Auth::user();
        if ($colocation->owner_id === $user->id) {
            $memberCount = $colocation->users()->wherePivot('left_at', null)->count();
            if ($memberCount > 1) {
                return back()->with('error', 'Owners cannot leave while other members are present. Kick them first.');
            }
        }
        $this->processReputationAndExit($user, $colocation);
        return redirect()->route('dashboard')->with('success', 'You left the colocation.');
    }

    public function removeMember(Colocation $colocation, User $member)
    {
        if (Auth::id() !== $colocation->owner_id) abort(403);
        $this->processReputationAndExit($member, $colocation);
        return back()->with('success', "Member {$member->name} removed.");
    }

    private function processReputationAndExit(User $user, Colocation $colocation)
    {
        $unpaidSettlements = Settlement::where('user_id', $user->id)
            ->whereHas('expense', function($query) use ($colocation) {
                $query->where('colocation_id', $colocation->id);
            })
            ->where('is_paid', false)
            ->get();

        if ($unpaidSettlements->count() > 0) {
            $user->decrement('reputation'); 
            if ($user->id !== $colocation->owner_id) {
                foreach ($unpaidSettlements as $s) {
                    $s->update(['user_id' => $colocation->owner_id]);
                }
            }
        } else {
            $user->increment('reputation'); 
        }
        $colocation->users()->updateExistingPivot($user->id, ['left_at' => now()]);
    }
}