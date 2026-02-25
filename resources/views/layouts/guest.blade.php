<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>EasyColoc — Authentication</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div>
                <a href="/">
                    <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center shadow-xl shadow-slate-200">
                        <span class="text-white font-black text-xl italic text-emerald-500">E</span>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-10 px-10 py-12 bg-white border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-[2.5rem]">
                {{ $slot }}
            </div>
            
            <p class="mt-8 text-[10px] font-black uppercase tracking-[0.3em] text-slate-300 italic">EasyColoc Financial Workstation</p>
        </div>
    </body>
</html>