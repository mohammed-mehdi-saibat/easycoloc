<x-guest-layout>
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-slate-900">Start Tracking</h2>
        <p class="text-slate-400 mt-2 font-medium text-sm">The first user becomes Global Admin</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="space-y-4">
            <input type="text" name="name" placeholder="Full Name" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 transition-all" required>
            
            <input type="email" name="email" placeholder="Email Address" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 transition-all" required>

            <input type="password" name="password" placeholder="Password" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 transition-all" required>

            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 transition-all" required>

            <button type="submit" class="w-full py-5 bg-emerald-600 text-white rounded-[1.5rem] font-bold uppercase tracking-widest text-xs hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-100 mt-4">
                Create Account
            </button>
        </div>
    </form>

    <div class="mt-10 text-center">
        <p class="text-sm text-slate-400 font-medium">
            Already have an account? <a href="{{ route('login') }}" class="text-slate-950 font-bold">Log in</a>
        </p>
    </div>
</x-guest-layout>