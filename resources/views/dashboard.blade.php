<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-4xl text-slate-900 leading-tight italic tracking-tighter uppercase">
                    {{ $activeColocation ? $activeColocation->name : 'Dashboard' }}
                </h2>
                <p class="text-slate-400 text-sm font-medium tracking-wide">
                    {{ $activeColocation ? 'Colocation Management' : 'Welcome to EasyColoc' }}
                </p>
            </div>
            <div class="flex items-center gap-4">
                <div class="px-4 py-2 bg-white shadow-sm rounded-xl border border-slate-100 text-center">
                    <span class="block text-[9px] font-black uppercase tracking-[0.2em] text-slate-400">Reputation</span>
                    <span class="text-lg font-black text-emerald-500">{{ auth()->user()->reputation }}</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            @if($pendingInvites->count() > 0)
                <div class="space-y-4">
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4 italic">Invitations Received</h3>
                    <div class="grid gap-4">
                        @foreach($pendingInvites as $invite)
                            <div class="bg-white border border-slate-200 shadow-sm rounded-[2rem] p-6 flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-xl font-black">!</div>
                                    <div>
                                        <h4 class="font-black text-slate-900 uppercase italic">Join "{{ $invite->colocation->name }}"</h4>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Invited by {{ $invite->inviter->name }}</p>
                                    </div>
                                </div>
                                @if(!$activeColocation)
                                    <a href="{{ route('invitations.accept', $invite->token) }}" class="px-8 py-3 bg-emerald-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-600 transition-all shadow-md shadow-emerald-500/20">
                                        Accept Invitation
                                    </a>
                                @else
                                    <span class="text-[10px] font-black text-slate-300 uppercase italic">Leave current group to join</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($activeColocation)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-8">
                        <div class="bg-white border border-slate-100 shadow-xl rounded-[2rem] p-8">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase rounded-full border border-emerald-100">Active Member</span>
                                    <h3 class="text-3xl font-black text-slate-900 mt-4 uppercase italic">{{ $activeColocation->name }}</h3>
                                    <p class="text-slate-400 font-medium text-sm mt-1">{{ $activeColocation->description }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="block text-2xl font-black text-slate-900">{{ number_format($totalSpent, 2) }} DH</span>
                                    <span class="text-[9px] font-black uppercase text-slate-400 tracking-widest">Total Group Spending</span>
                                </div>
                            </div>

                            <div class="mt-10 p-6 bg-slate-50 rounded-[2rem] border border-slate-100">
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4 italic">Log New Expense</h4>
                                <form action="{{ route('expenses.store', $activeColocation) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <input type="text" name="description" placeholder="Description" required class="border-none rounded-xl bg-white text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                                        <input type="number" name="amount" step="0.01" placeholder="Amount (DH)" required class="border-none rounded-xl bg-white text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                                        <select name="category_id" required class="border-none rounded-xl bg-white text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="date" name="spent_at" value="{{ date('Y-m-d') }}" required class="border-none rounded-xl bg-white text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                                    </div>
                                    <button type="submit" class="w-full py-3 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-600 transition-all shadow-lg">Save Expense</button>
                                </form>
                            </div>

                            <div class="mt-10">
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4 italic">Balances</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($activeColocation->users as $member)
                                        @if($member->pivot->left_at === null)
                                            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100 shadow-sm">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center font-black text-slate-400 text-sm">
                                                        {{ substr($member->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-black text-slate-800">{{ $member->name }}</p>
                                                        <p class="text-[9px] uppercase font-bold text-slate-400 tracking-tighter">{{ $member->pivot->role }} • Rep: {{ $member->reputation }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-4">
                                                    <div class="text-right">
                                                        <span class="block text-sm font-black {{ $member->current_balance >= 0 ? 'text-emerald-500' : 'text-rose-500' }}">
                                                            {{ $member->current_balance >= 0 ? '+' : '' }}{{ number_format($member->current_balance, 2) }} DH
                                                        </span>
                                                    </div>
                                                    <div class="flex flex-col gap-1">
                                                        @if(Auth::id() === $activeColocation->owner_id && $member->id !== Auth::id())
                                                            <form action="{{ route('colocations.remove-member', [$activeColocation, $member]) }}" method="POST">
                                                                @csrf
                                                                <button class="text-[8px] font-black text-rose-500 uppercase hover:underline">Kick</button>
                                                            </form>
                                                        @endif
                                                        @if(Auth::id() === $member->id)
                                                            <form action="{{ route('colocations.leave', $activeColocation) }}" method="POST">
                                                                @csrf
                                                                <button class="text-[8px] font-black text-rose-500 uppercase hover:underline">Leave Group</button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-10 bg-white border border-slate-100 shadow-sm rounded-[2rem] overflow-hidden">
                                <div class="p-6 border-b border-slate-50 flex flex-wrap justify-between items-center gap-4">
                                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 italic">Expense History</h4>
                                    <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-2">
                                        <select name="month" onchange="this.form.submit()" class="text-[10px] font-black uppercase border-slate-200 rounded-lg py-1 focus:ring-0">
                                            <option value="all">All Months</option>
                                            @foreach(range(1, 12) as $m)
                                                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <select name="category" onchange="this.form.submit()" class="text-[10px] font-black uppercase border-slate-200 rounded-lg py-1 focus:ring-0">
                                            <option value="all">All Categories</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left">
                                        <thead class="bg-slate-50 text-[9px] font-black uppercase text-slate-400 tracking-widest">
                                            <tr>
                                                <th class="px-8 py-4">Payer</th>
                                                <th class="px-8 py-4">Details</th>
                                                <th class="px-8 py-4 text-right">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-50">
                                            @forelse($expenses as $expense)
                                                <tr class="hover:bg-slate-50/50 transition-all">
                                                    <td class="px-8 py-4">
                                                        <p class="text-xs font-black text-slate-900">{{ $expense->payer->name }}</p>
                                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">{{ $expense->spent_at }}</p>
                                                    </td>
                                                    <td class="px-8 py-4">
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <span class="text-[9px] font-black uppercase px-2 py-1 bg-slate-100 rounded text-slate-500">{{ $expense->category->name }}</span>
                                                            <p class="text-xs font-medium text-slate-600">{{ $expense->description }}</p>
                                                        </div>
                                                        <div class="space-y-1">
                                                            @foreach($expense->settlements as $settlement)
                                                                <div class="flex items-center gap-2">
                                                                    <span class="text-[9px] font-bold {{ $settlement->is_paid ? 'text-emerald-500' : 'text-rose-500' }} uppercase">
                                                                        {{ $settlement->user->name }}: {{ number_format($settlement->amount, 2) }} DH 
                                                                        ({{ $settlement->is_paid ? 'Paid' : 'Unpaid' }})
                                                                    </span>
                                                                    @if(!$settlement->is_paid && (Auth::id() === $activeColocation->owner_id || Auth::id() === $expense->user_id))
                                                                        <form action="{{ route('settlements.confirm', $settlement) }}" method="POST" class="inline">
                                                                            @csrf
                                                                            <button class="text-[7px] bg-slate-900 text-white px-2 py-0.5 rounded-full uppercase font-black hover:bg-emerald-500 transition-all">Confirm</button>
                                                                        </form>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td class="px-8 py-4 text-right font-black text-slate-900 text-xs">
                                                        {{ number_format($expense->amount, 2) }} DH
                                                        @php
                                                            $anyPaid = $expense->settlements()->where('is_paid', true)->exists();
                                                        @endphp
                                                        @if(!$anyPaid && (Auth::id() === $expense->user_id || Auth::id() === $activeColocation->owner_id))
                                                            <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline ml-2">
                                                                @csrf @method('DELETE')
                                                                <button class="text-rose-500 hover:text-rose-700 font-bold">×</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="3" class="px-8 py-12 text-center text-slate-400 text-xs italic font-medium uppercase tracking-widest">No records found</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @if($activeColocation->pivot->role === 'owner')
                            <div class="bg-slate-900 rounded-[2rem] p-8 shadow-xl">
                                <h3 class="text-white text-lg font-black uppercase italic">Invite Member</h3>
                                <form action="{{ route('invitations.send', $activeColocation) }}" method="POST" class="mt-6 space-y-3">
                                    @csrf
                                    <input type="email" name="email" required placeholder="email@address.com" class="w-full bg-slate-800 border-none rounded-xl px-4 py-3 text-white text-sm focus:ring-2 focus:ring-emerald-500 transition-all">
                                    <button class="w-full py-3 bg-emerald-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-white hover:text-slate-900 transition-all shadow-lg">Send Invitation</button>
                                </form>
                            </div>
                            <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm">
                                <h3 class="text-slate-900 text-sm font-black uppercase italic">Group Categories</h3>
                                <form action="{{ route('categories.store') }}" method="POST" class="mt-6 flex gap-2">
                                    @csrf
                                    <input type="text" name="name" required placeholder="Ex: Internet" class="flex-1 bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-bold focus:ring-2 focus:ring-emerald-500 transition-all">
                                    <button class="bg-slate-900 text-white px-4 rounded-xl hover:bg-emerald-500 transition-all shadow-lg">+</button>
                                </form>
                            </div>
                        @else
                            <div class="bg-indigo-600 rounded-[2rem] p-8 shadow-xl text-white">
                                <h3 class="text-lg font-black uppercase italic">Group Member</h3>
                                <p class="text-indigo-100 text-xs mt-2 leading-relaxed font-medium">Active status in <strong>{{ $activeColocation->name }}</strong>.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white border border-slate-100 shadow-xl rounded-[3rem] p-12 max-w-2xl mx-auto text-center">
                    <h3 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter">Create Colocation</h3>
                    <form action="{{ route('colocations.store') }}" method="POST" class="mt-10 space-y-4">
                        @csrf
                        <input type="text" name="name" required placeholder="Colocation Name" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-bold text-sm focus:ring-2 focus:ring-slate-900 transition-all">
                        <textarea name="description" placeholder="Description" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-bold text-sm focus:ring-2 focus:ring-slate-900 transition-all"></textarea>
                        <button class="w-full py-4 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-emerald-600 transition-all">Create Now</button>
                    </form>
                </div>
            @endif

            @if(auth()->user()->global_role === 'admin')
                <div class="mt-20 pt-10 border-t-2 border-slate-100">
                    <h3 class="font-black text-2xl text-slate-900 uppercase italic tracking-tighter mb-8">System Admin Dashboard</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                            <span class="block text-[9px] font-black uppercase text-slate-400 tracking-[0.2em] mb-2">Platform Volume</span>
                            <span class="text-2xl font-black text-slate-900">{{ number_format($adminStats['total_platform_spent'], 2) }} DH</span>
                        </div>
                        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                            <span class="block text-[9px] font-black uppercase text-slate-400 tracking-[0.2em] mb-2">Total Communities</span>
                            <span class="text-2xl font-black text-slate-900">{{ $adminStats['total_groups'] }} Groups</span>
                        </div>
                        <div class="bg-slate-900 p-6 rounded-[2rem] shadow-xl text-white">
                            <span class="block text-[9px] font-black uppercase text-slate-500 tracking-[0.2em] mb-2">Top Spender</span>
                            <span class="text-lg font-black italic truncate block">{{ $adminStats['top_spender']?->name ?? 'N/A' }}</span>
                            <span class="text-[10px] font-bold text-emerald-400">{{ number_format($adminStats['top_spender']?->expenses_sum_amount ?? 0, 2) }} DH</span>
                        </div>
                        <div class="bg-emerald-500 p-6 rounded-[2rem] shadow-xl text-white">
                            <span class="block text-[9px] font-black uppercase text-emerald-100 tracking-[0.2em] mb-2">Most Active Group</span>
                            <span class="text-lg font-black italic truncate block">{{ $adminStats['top_group']?->name ?? 'N/A' }}</span>
                            <span class="text-[10px] font-bold text-slate-900">{{ number_format($adminStats['top_group']?->expenses_sum_amount ?? 0, 2) }} DH</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
                        <div class="lg:col-span-2 space-y-6">
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4 italic">Community Directory</h4>
                            <div class="bg-white border border-slate-100 shadow-xl rounded-[2rem] overflow-hidden">
                                <table class="w-full text-left">
                                    <thead class="bg-slate-50 text-[9px] font-black uppercase text-slate-400">
                                        <tr>
                                            <th class="px-8 py-4">Group Name</th>
                                            <th class="px-8 py-4 text-center">Members</th>
                                            <th class="px-8 py-4 text-right">Total Spent</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50">
                                        @foreach($allColocations as $coloc)
                                            <tr>
                                                <td class="px-8 py-4">
                                                    <p class="text-sm font-black text-slate-800">{{ $coloc->name }}</p>
                                                    <p class="text-[10px] text-slate-400 truncate max-w-xs">{{ $coloc->description }}</p>
                                                </td>
                                                <td class="px-8 py-4 text-center">
                                                    <span class="px-3 py-1 bg-slate-100 rounded-full text-[10px] font-bold">{{ $coloc->users_count }}</span>
                                                </td>
                                                <td class="px-8 py-4 text-right text-sm font-black text-slate-900">
                                                    {{ number_format($coloc->expenses_sum_amount ?? 0, 2) }} DH
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4 italic">Live Activity Feed</h4>
                            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm space-y-6">
                                @foreach($latestGlobalExpenses as $gExpense)
                                    <div class="flex gap-4 items-start border-b border-slate-50 pb-4 last:border-0 last:pb-0">
                                        <div class="w-2 h-2 rounded-full mt-1.5 {{ $loop->first ? 'bg-emerald-500 animate-pulse' : 'bg-slate-200' }}"></div>
                                        <div>
                                            <p class="text-xs text-slate-600 leading-relaxed">
                                                <span class="font-black text-slate-900">{{ $gExpense->payer->name }}</span> 
                                                spent <span class="font-black text-slate-900">{{ number_format($gExpense->amount, 2) }} DH</span>
                                            </p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">
                                                {{ $gExpense->category->name }} • {{ $gExpense->colocation->name }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                                @if($latestGlobalExpenses->isEmpty())
                                    <p class="text-[10px] text-slate-400 text-center uppercase font-black italic">No activity yet</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4 mb-4 italic">System User Management</h4>
                    <div class="bg-white border border-slate-100 shadow-xl rounded-[2rem] overflow-hidden">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50">
                                <tr class="text-[10px] font-black uppercase text-slate-400">
                                    <th class="px-8 py-4">User</th>
                                    <th class="px-8 py-4 text-center">Reputation</th>
                                    <th class="px-8 py-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($users as $user)
                                    <tr>
                                        <td class="px-8 py-5">
                                            <p class="font-black text-slate-800 text-sm tracking-tight">{{ $user->name }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $user->email }}</p>
                                        </td>
                                        <td class="px-8 py-5 text-center">
                                            <span class="text-sm font-black text-emerald-500 italic">{{ $user->reputation }}</span>
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            <form action="{{ route('admin.users.toggle-ban', $user) }}" method="POST">
                                                @csrf
                                                <button class="px-4 py-2 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $user->is_banned ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-rose-50 text-rose-600 border-rose-100 transition-colors hover:bg-rose-600 hover:text-white' }}">
                                                    {{ $user->is_banned ? 'Restore' : 'Ban' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>