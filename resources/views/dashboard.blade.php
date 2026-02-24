<x-app-layout>
    <div class="py-12 bg-[#F8FAFC]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="text-4xl font-black text-slate-950 tracking-tighter">Your Ledger</h2>
                    <p class="text-slate-400 font-medium mt-1">Hello, {{ Auth::user()->name }}. Manage your shared debts.</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-4 py-2 bg-emerald-100 text-emerald-700 rounded-xl text-xs font-black uppercase tracking-widest border border-emerald-200">
                        {{ Auth::user()->role }}
                    </span>
                    <span class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-black uppercase tracking-widest">
                        Rep: {{ Auth::user()->reputation }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-slate-950 p-12 rounded-[3rem] shadow-2xl relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-white text-3xl font-bold mb-4">No active groups.</h3>
                        <p class="text-slate-400 text-lg mb-8 max-w-sm">Ready to split a bill? Create an expense group for your roommates or project.</p>
                        <button class="bg-emerald-500 text-slate-950 px-10 py-5 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-emerald-400 transition-all">
                            + Start New Ledger
                        </button>
                    </div>
                    <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-emerald-500/10 rounded-full"></div>
                </div>

                <div class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm">
                    <h4 class="text-slate-950 font-bold text-lg mb-6 tracking-tight">Recent Activity</h4>
                    <div class="space-y-6">
                        <p class="text-slate-400 text-sm font-medium italic">No transactions yet...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>