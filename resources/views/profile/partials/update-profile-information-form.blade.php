<section>
    <header>
        <h2 class="text-xl font-bold text-slate-950 tracking-tight">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500 font-medium">
            {{ __("Update your account's public identity and contact email.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Full Name')" class="text-xs font-black uppercase text-slate-400 ml-1 mb-2" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full !bg-slate-50 !border-none !rounded-2xl !py-4 focus:!ring-emerald-500" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-xs font-black uppercase text-slate-400 ml-1 mb-2" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full !bg-slate-50 !border-none !rounded-2xl !py-4 focus:!ring-emerald-500" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-amber-50 rounded-2xl border border-amber-100">
                    <p class="text-sm text-amber-700 font-medium">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="ml-2 underline text-amber-800 hover:text-amber-950 font-bold">
                            {{ __('Resend link') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-bold text-xs uppercase tracking-widest text-emerald-600">
                            {{ __('Link sent to your inbox.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="!bg-slate-950 hover:!bg-slate-800 !px-10 !rounded-2xl shadow-lg shadow-slate-200">
                {{ __('Update Profile') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-bold text-emerald-600 flex items-center"
                >
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ __('Saved') }}
                </p>
            @endif
        </div>
    </form>
</section>