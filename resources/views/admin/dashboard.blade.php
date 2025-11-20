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
                Sistem siap bekerja. Mari kita mulai mengelola tim Anda.
            </p>

            <div class="mt-6">
                <a href="{{ route('projects.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-bold rounded-xl shadow-lg transition-all transform hover:scale-105">
                    + Kelola Projects
                </a>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-slate-900 p-6 rounded-2xl shadow-lg border border-slate-800 hover:border-indigo-500/50 transition-all group animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-indigo-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <span class="text-xs font-bold px-2 py-1 rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Total</span>
            </div>
            <h3 class="text-slate-400 text-sm font-medium uppercase">Projects</h3>
            <p class="text-3xl font-bold text-white mt-1">{{ $stats['total_projects'] }}</p>
        </div>

        <div class="bg-slate-900 p-6 rounded-2xl shadow-lg border border-slate-800 hover:border-purple-500/50 transition-all group animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-purple-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <span class="text-xs font-bold px-2 py-1 rounded-full bg-purple-500/10 text-purple-400 border border-purple-500/20">Active</span>
            </div>
            <h3 class="text-slate-400 text-sm font-medium uppercase">Total Staff</h3>
            <p class="text-3xl font-bold text-white mt-1">{{ $stats['total_staff'] }}</p>
        </div>
        
        <div class="bg-slate-900 p-6 rounded-2xl shadow-lg border border-slate-800 hover:border-red-500/50 transition-all group animate-fade-in-up" style="animation-delay: 0.3s;">
             <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-red-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                 <span class="text-xs font-bold px-2 py-1 rounded-full bg-red-500/10 text-red-400 border border-red-500/20">Pending</span>
            </div>
            <h3 class="text-slate-400 text-sm font-medium uppercase">Unfinished Tasks</h3>
            <p class="text-3xl font-bold text-white mt-1">{{ $stats['pending_tasks'] }}</p>
        </div>
    </div>
</x-app-layout>