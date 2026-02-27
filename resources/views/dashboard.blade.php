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
                                    <span class="block text-2xl font-black text-slate-900">0.00 DH</span>
                                    <span class="text-[9px] font-black uppercase text-slate-400 tracking-widest">Total Expenses</span>
                                </div>
                            </div>

                            <div class="mt-10">
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Member List</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($activeColocation->users as $member)
                                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center font-bold text-slate-400 text-xs">
                                                    {{ substr($member->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-black text-slate-800">{{ $member->name }}</p>
                                                    <p class="text-[9px] uppercase font-bold text-slate-400">{{ $member->pivot->role }}</p>
                                                </div>
                                            </div>
                                            <span class="text-xs font-bold text-slate-900">0.00 DH</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @if($activeColocation->pivot->role === 'owner')
                            <div class="bg-slate-900 rounded-[2rem] p-8 shadow-xl">
                                <h3 class="text-white text-lg font-black uppercase italic">Invite Member</h3>
                                <p class="text-slate-400 text-xs mt-2 leading-relaxed">Add a new person to your colocation via email.</p>
                                
                                <form action="{{ route('invitations.send', $activeColocation) }}" method="POST" class="mt-6 space-y-3">
                                    @csrf
                                    <input type="email" name="email" required placeholder="email@address.com" 
                                           class="w-full bg-slate-800 border-none rounded-xl px-4 py-3 text-white text-sm focus:ring-2 focus:ring-emerald-500 transition-all">
                                    <button class="w-full py-3 bg-emerald-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-white hover:text-slate-900 transition-all shadow-lg shadow-emerald-500/20">
                                        Send Invitation
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="p-8 bg-emerald-50 border border-emerald-100 rounded-[2rem]">
                                <h3 class="text-emerald-900 text-sm font-black uppercase italic">Member Info</h3>
                                <p class="text-emerald-600/70 text-xs mt-2 leading-relaxed font-medium">You are part of this colocation. Expense tracking and balance management will be available here soon.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white border border-slate-100 shadow-xl rounded-[3rem] p-12 max-w-2xl mx-auto text-center">
                    <h3 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter">Create Colocation</h3>
                    <p class="text-slate-400 mt-2">Start a new group to manage shared house expenses.</p>
                    
                    <form action="{{ route('colocations.store') }}" method="POST" class="mt-10 space-y-4 text-left">
                        @csrf
                        <input type="text" name="name" required placeholder="Colocation Name" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-bold text-sm focus:ring-2 focus:ring-slate-900 transition-all">
                        <textarea name="description" placeholder="Description (Optional)" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-bold text-sm focus:ring-2 focus:ring-slate-900 transition-all"></textarea>
                        <button class="w-full py-4 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-emerald-600 transition-all shadow-xl shadow-slate-200">
                            Create Now
                        </button>
                    </form>
                </div>
            @endif

            @if($pendingInvites->count() > 0)
                <div class="space-y-4 pt-10 border-t border-slate-100">
                    <div class="flex items-center justify-between ml-4">
                        <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Invitations</h3>
                        @if($activeColocation)
                            <span class="text-[10px] font-bold text-rose-400 uppercase italic">You must leave your current colocation to join another</span>
                        @endif
                    </div>
                    
                    @foreach($pendingInvites as $invite)
                        <div class="bg-white border border-slate-200 shadow-sm rounded-3xl p-6 flex flex-col md:flex-row items-center justify-between gap-6 {{ $activeColocation ? 'opacity-50' : '' }}">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 {{ $activeColocation ? 'bg-slate-100 text-slate-400' : 'bg-emerald-100 text-emerald-600' }} rounded-2xl flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-black text-slate-900 uppercase">Join "{{ $invite->colocation->name }}"</h4>
                                    <p class="text-xs text-slate-400">Invited by {{ $invite->inviter->name }}</p>
                                </div>
                            </div>
                            
                            @if($activeColocation)
                                <span class="px-8 py-3 bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest rounded-xl border border-slate-100 cursor-not-allowed">
                                    Occupied
                                </span>
                            @else
                                <a href="{{ route('invitations.accept', $invite->token) }}" class="px-8 py-3 bg-emerald-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-600 transition-all">
                                    Accept Invitation
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            @if(auth()->user()->global_role === 'admin')
                <div class="mt-20 pt-10 border-t-2 border-slate-100">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="font-black text-2xl text-slate-900 uppercase italic tracking-tighter underline decoration-emerald-500 decoration-4 underline-offset-8">Global Management</h3>
                            <p class="text-slate-400 text-xs font-bold uppercase mt-3">System Administration & User History</p>
                        </div>
                    </div>

                    <div class="bg-white border border-slate-100 shadow-xl rounded-[2rem] overflow-hidden">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr class="text-[10px] font-black uppercase text-slate-400">
                                    <th class="px-8 py-4 tracking-widest">User</th>
                                    <th class="px-8 py-4 text-center tracking-widest">Reputation</th>
                                    <th class="px-8 py-4 text-right tracking-widest">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($users as $user)
                                    <tr class="hover:bg-slate-50/50 transition-all">
                                        <td class="px-8 py-5">
                                            <p class="font-black text-slate-800 text-sm">{{ $user->name }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $user->email }}</p>
                                        </td>
                                        <td class="px-8 py-5 text-center">
                                            <span class="text-sm font-black text-emerald-500 italic">{{ $user->reputation }}</span>
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            <form action="{{ route('admin.users.toggle-ban', $user) }}" method="POST">
                                                @csrf
                                                <button class="px-4 py-2 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $user->is_banned ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-rose-50 text-rose-600 border-rose-100' }}">
                                                    {{ $user->is_banned ? 'Restore User' : 'Ban User' }}
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