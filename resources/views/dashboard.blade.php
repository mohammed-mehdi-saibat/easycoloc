<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Pending Invitations --}}
            @if(isset($pendingInvites) && $pendingInvites->count() > 0)
                @foreach($pendingInvites as $invite)
                    <div class="mb-6 p-6 bg-emerald-50 border border-emerald-100 rounded-[2rem] flex items-center justify-between shadow-sm">
                        <div>
                            <p class="text-emerald-900 font-bold">
                                You've been invited to join <span class="italic text-emerald-600">"{{ $invite->colocation->name }}"</span>
                            </p>
                        </div>
                        <a href="{{ route('invitations.accept', $invite->token) }}" 
                           class="px-6 py-2 bg-emerald-500 text-white rounded-xl font-bold text-sm hover:bg-emerald-600 transition-all">
                            Accept & Join
                        </a>
                    </div>
                @endforeach
            @endif

            @if(!auth()->user()->hasColocation())
                {{-- Create Group State --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-[2.5rem] border border-slate-100">
                    <div class="p-12 text-center">
                        <div class="w-20 h-20 bg-emerald-50 text-emerald-600 rounded-3xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight">Start a New Ledger</h3>
                        <p class="text-slate-500 mt-2 mb-8 max-w-sm mx-auto font-medium">Create a group to start tracking shared expenses.</p>
                        
                        <form action="{{ route('colocations.store') }}" method="POST" class="max-w-md mx-auto space-y-4">
                            @csrf
                            <input type="text" name="name" placeholder="Group Name" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 transition-all font-bold" required>
                            <textarea name="description" placeholder="Description (optional)" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 transition-all font-medium"></textarea>
                            <button type="submit" class="w-full py-4 bg-emerald-500 text-white rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-emerald-600 transition-all">
                                Create My Ledger
                            </button>
                        </form>
                    </div>
                </div>
            @else
                {{-- Active Group Dashboard --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                        <h2 class="text-4xl font-black text-slate-900 tracking-tighter italic">
                            {{ auth()->user()->colocations->first()->name }}
                        </h2>
                        <p class="text-slate-400 mt-1 font-bold uppercase tracking-widest text-[10px] mb-8">Active Ledger</p>
                        
                        {{-- Participants List with Specific Roles --}}
                        <h4 class="text-sm font-black uppercase tracking-widest text-slate-900 mb-4">Participants</h4>
                        <div class="flex flex-wrap gap-4">
                            @foreach(auth()->user()->colocations->first()->users as $member)
                                <div class="flex items-center gap-3 bg-slate-50 pr-4 rounded-full border border-slate-100">
                                    <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center text-white text-xs font-bold">
                                        {{ strtoupper(substr($member->name, 0, 2)) }}
                                    </div>
                                    <span class="text-sm font-bold text-slate-700">{{ $member->name }}</span>
                                    
                                    {{-- Role Check --}}
                                    @if($member->id === auth()->user()->colocations->first()->owner_id)
                                        <span class="text-[8px] bg-slate-900 px-2 py-0.5 rounded text-white font-black uppercase tracking-tighter">Owner</span>
                                    @else
                                        <span class="text-[8px] bg-emerald-100 px-2 py-0.5 rounded text-emerald-600 font-black uppercase tracking-tighter">Member</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Sidebar: Exclusive to the Owner --}}
                    <div class="space-y-6">
                        @if(auth()->id() === auth()->user()->colocations->first()->owner_id)
                            <div class="bg-slate-950 p-8 rounded-[2.5rem] shadow-xl text-white">
                                <h4 class="font-bold mb-4">Invite Member</h4>
                                <p class="text-[10px] text-slate-400 mb-4 leading-relaxed font-medium">As the owner, you can add new members to this ledger via email.</p>
                                <form action="{{ route('invitations.send', auth()->user()->colocations->first()->id) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <input type="email" name="email" placeholder="friend@email.com" class="w-full px-4 py-3 bg-slate-800 border-none rounded-xl focus:ring-2 focus:ring-emerald-500 text-sm font-medium text-white placeholder:text-slate-500" required>
                                    <button type="submit" class="w-full py-3 bg-white text-slate-950 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-emerald-400 transition-all">
                                        Send Invite
                                    </button>
                                </form>
                            </div>
                        @else
                            {{-- View for Members --}}
                            <div class="bg-emerald-500 p-8 rounded-[2.5rem] shadow-xl text-white">
                                <h4 class="font-bold mb-2">Member View</h4>
                                <p class="text-xs opacity-90 leading-relaxed font-medium">You are a participant in this ledger. Only the owner can manage new invitations.</p>
                                <div class="mt-6 pt-4 border-t border-emerald-400/30">
                                    <span class="text-[10px] font-black uppercase tracking-widest">Status: Verified</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>