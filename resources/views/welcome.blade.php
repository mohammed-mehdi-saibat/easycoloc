<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>EasyColoc — Shared Expenses, Simplified.</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800,900&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-white text-slate-900 overflow-x-hidden">
        
        <nav class="max-w-7xl mx-auto px-6 py-10 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-slate-900 rounded-lg flex items-center justify-center">
                    <span class="text-white font-black text-xs">E</span>
                </div>
                <span class="text-lg font-black tracking-tighter uppercase italic">EasyColoc</span>
            </div>
    
            @if (Route::has('login'))
                <div class="flex items-center gap-8">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-slate-600 hover:text-slate-900 transition-colors">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-slate-900 transition-colors">
                            Sign In
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-3 bg-black  text-white rounded-xl text-sm font-bold hover:bg-emerald-600 transition-all shadow-lg shadow-black/10">
                                Get Started
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
    </nav>

        <main class="max-w-7xl mx-auto px-6 pt-20 pb-32 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-block px-4 py-1.5 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-full mb-6">Built for Modern Living</span>
                <h1 class="text-7xl lg:text-8xl font-black tracking-[-0.05em] leading-[0.9] text-slate-900 mb-8 italic">
                    Stop Guessing, <br> <span class="text-emerald-500 underline decoration-slate-200 decoration-8 underline-offset-8">Start Settling.</span>
                </h1>
                <p class="text-lg text-slate-500 font-medium leading-relaxed max-w-md mb-10">
                    The ultimate workstation for shared household expenses. Track, split, and settle debts with professional-grade clarity.
                </p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-emerald-600 transition-all shadow-2xl shadow-slate-200">
                        Create Your Group
                    </a>
                    <div class="flex -space-x-3 overflow-hidden ml-4">
                        <div class="inline-block h-10 w-10 rounded-full ring-2 ring-white bg-slate-100 flex items-center justify-center text-[10px] font-bold">JD</div>
                        <div class="inline-block h-10 w-10 rounded-full ring-2 ring-white bg-slate-100 flex items-center justify-center text-[10px] font-bold text-emerald-500">AS</div>
                        <div class="inline-block h-10 w-10 rounded-full ring-2 ring-white bg-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-400">+12</div>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="bg-slate-50 rounded-[3rem] p-8 aspect-square flex items-center justify-center border border-slate-100 shadow-inner">
                    <div class="w-full max-w-xs space-y-4">
                        <div class="bg-white p-6 rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-50 transform -rotate-3 hover:rotate-0 transition-transform cursor-default">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">Recent Expense</span>
                                <span class="text-xs font-bold text-slate-400">Today</span>
                            </div>
                            <p class="text-xl font-black text-slate-900 mb-1 leading-tight italic">Grocery Shopping</p>
                            <p class="text-3xl font-black text-slate-900">€84.50</p>
                        </div>
                        <div class="bg-slate-900 p-6 rounded-3xl shadow-xl transform rotate-3 hover:rotate-0 transition-transform cursor-default">
                            <div class="flex justify-between items-center mb-4 text-white/50 uppercase tracking-[0.2em] text-[10px] font-bold">
                                <span>Balance Status</span>
                            </div>
                            <p class="text-emerald-400 text-sm font-bold">You are owed €42.25</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>