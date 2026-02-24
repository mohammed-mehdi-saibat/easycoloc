<x-guest-layout>
    @if (session('status'))
        <div class="mb-8 p-5 bg-rose-50 border border-rose-100 rounded-[2rem] flex items-center gap-4">
            <div class="shrink-0 w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center text-rose-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <p class="text-xs font-black uppercase tracking-widest text-rose-600 leading-relaxed">
                {{ session('status') }}
            </p>
        </div>
    @endif

    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Welcome back</h2>
        <p class="text-slate-400 mt-2 font-medium text-sm">Access your shared expenses</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="space-y-6">
            <div>
                <input type="email" name="email" placeholder="Email Address" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 transition-all placeholder:text-slate-300 font-medium" required autofocus>
                <x-input-error :messages="$errors->get('email')" class="mt-2 ml-2" />
            </div>

            <div>
                <input type="password" name="password" placeholder="Password" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 transition-all placeholder:text-slate-300 font-medium" required>
                <x-input-error :messages="$errors->get('password')" class="mt-2 ml-2" />
            </div>

            <div class="flex items-center justify-between px-2">
                <label class="flex items-center text-sm text-slate-400 font-bold cursor-pointer uppercase tracking-tighter">
                    <input type="checkbox" name="remember" class="rounded-md border-slate-200 text-emerald-600 focus:ring-emerald-500 mr-2 bg-slate-50">
                    Remember
                </label>
                <a href="{{ route('password.request') }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-700 transition-colors">Forgot?</a>
            </div>

            <button type="submit" class="w-full py-5 bg-slate-950 text-white rounded-[1.8rem] font-black uppercase tracking-[0.2em] text-[10px] hover:bg-slate-800 transition-all shadow-2xl shadow-slate-200 active:scale-[0.98]">
                Log In
            </button>
        </div>
    </form>

    <div class="mt-12 text-center">
        <p class="text-sm text-slate-400 font-medium">
            New here? <a href="{{ route('register') }}" class="text-emerald-600 font-black hover:underline decoration-2 underline-offset-4">Create a ledger</a>
        </p>
    </div>
</x-guest-layout>