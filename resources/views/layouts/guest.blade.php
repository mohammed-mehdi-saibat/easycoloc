<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Coloc') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-[#F8FAFC] text-slate-900">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-8 transform hover:scale-105 transition-transform duration-300">
                <a href="/">
                    <span class="text-3xl font-black tracking-tighter text-slate-900">
                        co<span class="text-emerald-600">loc.</span>
                    </span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-10 py-12 bg-white shadow-[0_32px_64px_-15px_rgba(0,0,0,0.08)] rounded-[3rem] border border-slate-100">
                {{ $slot }}
            </div>
            
            <p class="mt-8 text-slate-400 text-xs font-medium uppercase tracking-[0.2em]">Secure Ledger v2.0</p>
        </div>
    </body>
</html>