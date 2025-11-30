<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white tracking-tight">
            {{ __('My Projects') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Notifikasi Overdue Alert --}}
            @if($stats['overdue_count'] > 0)
                <div class="mb-6 bg-red-500/10 border border-red-500/30 rounded-2xl p-4">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-red-300 mb-2">⚠️ Ada {{ $stats['overdue_count'] }} Tugas Terlewat!</h3>
                            <p class="text-sm text-red-200 mb-3">Deadline Anda sudah terlewat. Segera selesaikan atau hubungi manager.</p>
                            <div class="space-y-1">
                                @foreach($overdueTasks as $task)
                                    <a href="{{ route('tasks.show', $task) }}" class="flex items-center gap-2 text-sm text-red-300 hover:text-red-200 transition-colors">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                        <span>{{ $task->title }}</span>
                                        <span class="text-[11px] text-red-400">(Deadline: {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }})</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-slate-900 p-6 rounded-2xl shadow-lg border border-slate-800">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-indigo-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-7l-2-2H5a2 2 0 00-2 2z"/></svg>
                        </div>
                        <span class="text-xs font-bold px-2 py-1 rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">My Projects</span>
                    </div>
                    <h3 class="text-slate-400 text-sm font-medium uppercase">Project yang Saya Ikuti</h3>
                    <p class="text-3xl font-bold text-white mt-1">{{ $stats['my_projects'] }}</p>
                </div>

                <div class="bg-slate-900 p-6 rounded-2xl shadow-lg border border-slate-800">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-red-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs font-bold px-2 py-1 rounded-full bg-red-500/10 text-red-400 border border-red-500/20">Overdue</span>
                    </div>
                    <h3 class="text-slate-400 text-sm font-medium uppercase">Tugas Terlewat</h3>
                    <p class="text-3xl font-bold text-white mt-1">{{ $stats['overdue_count'] }}</p>
                </div>
            </div>

            {{-- Projects Grid --}}
            <h3 class="text-lg font-bold text-white mb-4">Projects</h3>
            @if($projects->isEmpty())
                <div class="text-center py-12 bg-slate-900 border border-slate-800 rounded-2xl">
                    <svg class="w-16 h-16 mx-auto text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    <p class="text-slate-400 text-lg">Belum ada project yang Anda ikuti</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($projects as $project)
                        <a href="{{ route('projects.show', $project) }}" class="group bg-slate-900 border border-slate-800 rounded-2xl p-6 hover:border-indigo-500/50 hover:shadow-xl transition-all">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <span class="text-[10px] text-slate-400 uppercase font-bold tracking-wide">Project</span>
                                    <h3 class="text-lg font-bold text-white group-hover:text-indigo-400 transition-colors">{{ $project->name }}</h3>
                                </div>
                            </div>
                            
                            <p class="text-sm text-slate-400 mb-4 line-clamp-2">{{ $project->description }}</p>
                            
                            <div class="grid grid-cols-2 gap-2 mb-4 pt-4 border-t border-slate-800">
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-indigo-400">{{ $project->tasks->count() }}</p>
                                    <p class="text-[11px] text-slate-500 uppercase">Tasks</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-emerald-400">{{ $project->tasks->where('status', 'completed')->count() }}</p>
                                    <p class="text-[11px] text-slate-500 uppercase">Selesai</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-end text-slate-500 group-hover:text-indigo-400 transition-colors">
                                <span class="text-sm font-bold">Lihat Detail</span>
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>