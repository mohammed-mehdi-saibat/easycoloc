<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-black tracking-tight text-slate-900 italic">Create Account</h2>
        <p class="text-slate-400 font-medium text-sm mt-1">Join the future of shared living.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Full Name</label>
            <x-text-input id="name" class="block mt-1 w-full !rounded-2xl !border-slate-100 !bg-slate-50 shadow-none focus:!ring-emerald-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-6">
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Work/Personal Email</label>
            <x-text-input id="email" class="block mt-1 w-full !rounded-2xl !border-slate-100 !bg-slate-50 shadow-none focus:!ring-emerald-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-6">
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Password</label>
            <x-text-input id="password" class="block mt-1 w-full !rounded-2xl !border-slate-100 !bg-slate-50 shadow-none focus:!ring-emerald-500" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-6">
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Confirm Password</label>
            <x-text-input id="password_confirmation" class="block mt-1 w-full !rounded-2xl !border-slate-100 !bg-slate-50 shadow-none focus:!ring-emerald-500" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col items-center justify-end mt-10 gap-4">
            <button class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-emerald-600 transition-all shadow-xl shadow-slate-200">
                Establish Identity
            </button>
            
            <a class="text-xs font-bold text-slate-400 hover:text-slate-900 transition-colors" href="{{ route('login') }}">
                Already have an account? <span class="text-emerald-500">Sign In</span>
            </a>
        </div>
    </form>
</x-guest-layout>