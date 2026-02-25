<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-4xl text-slate-900 leading-tight italic tracking-tighter uppercase">
                    {{ auth()->user()->global_role === 'admin' ? 'Terminal' : 'Dashboard' }}
                </h2>
                <p class="text-slate-400 text-sm font-medium tracking-wide">
                    {{ auth()->user()->global_role === 'admin' 
                        ? 'System Oversight & User Management' 
                        : 'Personal Financial Overview & Ledger' }}
                </p>
            </div>
            
            <div class="flex items-center gap-4 bg-slate-50 p-2 rounded-2xl border border-slate-100">
                <div class="px-4 py-2 bg-white shadow-sm rounded-xl border border-slate-100">
                    <span class="block text-[9px] font-black uppercase tracking-[0.2em] text-slate-400">Reputation</span>
                    <span class="text-lg font-black text-emerald-500">{{ auth()->user()->reputation }}</span>
                </div>
                <div class="px-4 py-2">
                    <span class="block text-[9px] font-black uppercase tracking-[0.2em] text-slate-400">Network Status</span>
                    <span class="flex items-center gap-2 text-xs font-bold text-slate-900">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        Operational
                    </span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            
            @if(auth()->user()->global_role === 'admin')
            <div class="bg-white border border-slate-100 shadow-[0_30px_60px_-15px_rgba(0,0,0,0.05)] rounded-[3rem] overflow-hidden">
                <div class="px-10 py-8 border-b border-slate-50 flex items-center justify-between bg-white">
                    <div>
                        <h3 class="font-black text-slate-900 uppercase tracking-widest text-sm italic">User Registry</h3>
                        <p class="text-xs text-slate-400 font-medium mt-1">Total active nodes: {{ count($users) + 1 }}</p>
                    </div>
                    <button class="px-5 py-2.5 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-600 transition-all">
                        Export Data
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[10px] font-black uppercase tracking-widest text-slate-300 border-b border-slate-50 bg-slate-50/30">
                                <th class="px-10 py-5">Identity Details</th>
                                <th class="px-10 py-5 text-center">Reputation</th>
                                <th class="px-10 py-5 text-center">Security Status</th>
                                <th class="px-10 py-5 text-right">Access Control</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($users as $user)
                            <tr class="group hover:bg-slate-50/80 transition-all">
                                <td class="px-10 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-black text-slate-400 group-hover:bg-emerald-100 group-hover:text-emerald-600 transition-colors">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-black text-slate-900 text-sm tracking-tight">{{ $user->name }}</div>
                                            <div class="text-xs text-slate-400 font-medium">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-6 text-center">
                                    <span class="font-black text-slate-700 text-sm italic">{{ $user->reputation }}</span>
                                </td>
                                <td class="px-10 py-6 text-center">
                                    <div class="flex justify-center">
                                        @if($user->is_banned)
                                            <span class="flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-600 text-[10px] font-black uppercase rounded-lg border border-rose-100">
                                                Suspended
                                            </span>
                                        @else
                                            <span class="flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase rounded-lg border border-emerald-100">
                                                Verified
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-10 py-6 text-right">
                                    <form action="{{ route('admin.users.toggle-ban', $user) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all
                                            {{ $user->is_banned 
                                                ? 'bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white' 
                                                : 'bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white' }}">
                                            {{ $user->is_banned ? 'Restore Access' : 'Terminate' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-10 py-6 bg-slate-50/50 border-t border-slate-50 text-center">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 tracking-[0.3em]">EasyColoc Security Protocol</p>
                </div>
            </div>
            @else
            <div class="bg-white border border-slate-100 shadow-xl rounded-[3rem] p-16 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                </div>
                <h3 class="text-2xl font-black text-slate-900 italic uppercase tracking-tighter">No Active Ledger</h3>
                <p class="text-slate-400 mt-2 font-medium max-w-xs mx-auto text-sm">You aren't part of a colocation yet. Start a house to track expenses.</p>
                <div class="mt-8">
                    <button class="px-8 py-4 bg-slate-900 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-emerald-600 transition-all shadow-xl shadow-slate-200">
                        Initialize New Colocation
                    </button>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>