<section>
    <header>
        <h2 class="text-xl font-bold text-slate-950 tracking-tight">
            {{ __('Update Password') }}
        </h2>
        <p class="mt-1 text-sm text-slate-500 font-medium">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-xs font-black uppercase text-slate-400 ml-1 mb-2" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full !bg-slate-50 !border-none !rounded-2xl !py-4 focus:!ring-emerald-500" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-xs font-black uppercase text-slate-400 ml-1 mb-2" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full !bg-slate-50 !border-none !rounded-2xl !py-4 focus:!ring-emerald-500" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-xs font-black uppercase text-slate-400 ml-1 mb-2" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full !bg-slate-50 !border-none !rounded-2xl !py-4 focus:!ring-emerald-500" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="!bg-slate-950 hover:!bg-slate-800 !px-10 !rounded-2xl shadow-lg shadow-slate-200">
                {{ __('Update Password') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-bold text-emerald-600">
                    {{ __('Saved') }}
                </p>
            @endif
        </div>
    </form>
</section>