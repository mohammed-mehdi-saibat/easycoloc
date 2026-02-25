<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-3xl text-slate-900 leading-tight italic tracking-tight">
                {{ __('Command Center') }}
            </h2>
            <div class="flex items-center gap-3">
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Reputation Score</span>
                <span class="px-4 py-1 bg-emerald-50 text-emerald-600 rounded-full font-black text-sm">
                    {{ Auth::user()->reputation }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-2 bg-white overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-slate-100 rounded-[2.5rem] p-10">
                    <h3 class="text-2xl font-black text-slate-900 mb-2">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}!</h3>
                    <p class="text-slate-500 font-medium max-w-md">
                        @if(Auth::user()->global_role === 'admin')
                            Platform is running smoothly. You have full administrative access to monitor colocations and users.
                        @else
                            Manage your shared expenses and keep your reputation high by settling debts on time.
                        @endif
                    </p>

                    <div class="mt-8 flex gap-4">
                        @if(Auth::user()->global_role === 'admin')
                            <a href="#" class="px-6 py-3 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-emerald-600 transition-all">Global Stats</a>
                            <a href="#" class="px-6 py-3 bg-white border border-slate-200 text-slate-900 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all">Moderate Users</a>
                        @else
                            @if(!Auth::user()->hasColocation())
                                <a href="#" class="px-6 py-3 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-lg shadow-slate-200">Start New Coloc</a>
                                <a href="#" class="px-6 py-3 bg-white border border-slate-200 text-slate-900 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all">Join Group</a>
                            @else
                                <a href="#" class="px-6 py-3 bg-emerald-500 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-900 transition-all shadow-lg shadow-emerald-200">View My House</a>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-slate-300">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white/40">Identity Status</span>
                    <div class="mt-6 space-y-6">
                        <div>
                            <p class="text-xs font-bold text-white/60">Global Role</p>
                            <p class="text-xl font-black italic text-emerald-400 uppercase tracking-tighter">{{ Auth::user()->global_role }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-white/60">Account Security</p>
                            <p class="text-sm font-bold">{{ Auth::user()->is_banned ? 'Suspended' : 'Verified & Active' }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>