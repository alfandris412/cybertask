<x-app-layout>
    <x-slot name="header">
        {{ __('Overview') }}
    </x-slot>

    <div class="relative rounded-2xl p-8 shadow-2xl overflow-hidden bg-slate-900 border border-slate-800 mb-8 transition-transform duration-300 transform hover:scale-[1.005]">
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-indigo-600/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-64 h-64 bg-purple-600/20 rounded-full blur-3xl"></div>
        
        <div class="relative z-10">
            <h2 class="text-3xl font-bold mb-3 text-white">Halo, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-slate-400 text-lg max-w-2xl">
                Fokus pada tugas Anda dan capai target hari ini. Semangat!
            </p>

            <div class="mt-6">
                <button class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-bold rounded-xl shadow-lg transition-all transform hover:scale-105">
                    Lihat Daftar Tugas
                </button>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-slate-900 p-6 rounded-2xl shadow-lg border border-slate-800 hover:border-indigo-500/50 transition-all group animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-indigo-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <span class="text-xs font-bold px-2 py-1 rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">My Load</span>
            </div>
            <h3 class="text-slate-400 text-sm font-medium uppercase">Tugas Saya (Aktif)</h3>
            <p class="text-3xl font-bold text-white mt-1">{{ $stats['my_tasks'] }}</p>
        </div>

        <div class="bg-slate-900 p-6 rounded-2xl shadow-lg border border-slate-800 hover:border-green-500/50 transition-all group animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="flex items-center justify-between mb-4">
                 <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-green-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span class="text-xs font-bold px-2 py-1 rounded-full bg-green-500/10 text-green-400 border border-green-500/20">Done</span>
            </div>
            <h3 class="text-slate-400 text-sm font-medium uppercase">Tugas Selesai</h3>
            <p class="text-3xl font-bold text-white mt-1">{{ $stats['completed_tasks'] ?? 0 }}</p>
        </div>
    </div>
</x-app-layout>