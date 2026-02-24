<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coloc. | Split bills, keep peace.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-[#F8FAFC] text-slate-900">
    <div class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[600px] bg-emerald-50/50 rounded-full blur-3xl -z-10"></div>

        <div class="text-center px-6 max-w-4xl">
            <div class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-widest mb-8 border border-emerald-200">
                Fintech for Shared Living
            </div>
            <h1 class="text-6xl md:text-8xl font-black text-slate-950 tracking-tight mb-8">
                Split bills. <br>
                <span class="text-emerald-600 italic underline decoration-slate-200">No drama.</span>
            </h1>
            <p class="text-xl text-slate-500 mb-12 max-w-xl mx-auto font-medium leading-relaxed">
                Shared bills, minus the 'who owes what' headache.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="px-10 py-5 bg-slate-950 text-white rounded-2xl font-bold hover:bg-slate-800 transition-all shadow-2xl shadow-slate-200 text-lg">
                    Start a Ledger
                </a>
                <a href="{{ route('login') }}" class="px-10 py-5 bg-white text-slate-600 border border-slate-200 rounded-2xl font-bold hover:bg-slate-50 transition-all text-lg">
                    Sign In
                </a>
            </div>
        </div>
    </div>
</body>
</html>