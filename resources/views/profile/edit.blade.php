<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-slate-950 tracking-tight">
            {{ __('Account Settings') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F8FAFC]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-24 h-24 bg-emerald-100 rounded-[2rem] flex items-center justify-center text-emerald-600 text-3xl font-black mb-4">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h3 class="text-xl font-bold text-slate-950">{{ Auth::user()->name }}</h3>
                        <p class="text-slate-400 font-medium text-sm">{{ Auth::user()->email }}</p>
                        
                        <div class="mt-8 w-full space-y-3">
                            <div class="flex justify-between p-4 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-bold uppercase text-slate-400 tracking-widest">Role</span>
                                <span class="text-xs font-black uppercase text-slate-950">{{ Auth::user()->role }}</span>
                            </div>
                            <div class="flex justify-between p-4 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-bold uppercase text-slate-400 tracking-widest">Reputation</span>
                                <span class="text-xs font-black uppercase text-emerald-600">{{ Auth::user()->reputation }} Points</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-8">
                    <div class="p-8 bg-white border border-slate-100 shadow-sm rounded-[3rem]">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="p-8 bg-white border border-slate-100 shadow-sm rounded-[3rem]">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div class="p-8 bg-rose-50 border border-rose-100 shadow-sm rounded-[3rem]">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>     