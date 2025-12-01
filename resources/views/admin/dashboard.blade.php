<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-white tracking-tight">
                {{ __('Projects') }}
            </h2>
            <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-bold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Project
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-slate-900 p-6 rounded-2xl shadow-lg border border-slate-800">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-indigo-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-7l-2-2H5a2 2 0 00-2 2z"/></svg>
                        </div>
                        <span class="text-xs font-bold px-2 py-1 rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Total</span>
                    </div>
                    <h3 class="text-slate-400 text-sm font-medium uppercase">Total Projects</h3>
                    <p class="text-3xl font-bold text-white mt-1">{{ $stats['total_projects'] }}</p>
                </div>

                <div class="bg-slate-900 p-6 rounded-2xl shadow-lg border border-slate-800">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-emerald-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs font-bold px-2 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Selesai</span>
                    </div>
                    <h3 class="text-slate-400 text-sm font-medium uppercase">Tasks Selesai</h3>
                    <p class="text-3xl font-bold text-white mt-1">{{ $stats['completed_tasks'] }} / {{ $stats['total_tasks'] }}</p>
                </div>

                <div class="bg-slate-900 p-6 rounded-2xl shadow-lg border border-slate-800">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-yellow-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs font-bold px-2 py-1 rounded-full bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">Proses</span>
                    </div>
                    <h3 class="text-slate-400 text-sm font-medium uppercase">Tasks Pending</h3>
                    <p class="text-3xl font-bold text-white mt-1">{{ $stats['pending_tasks'] }}</p>
                </div>

                <div class="bg-slate-900 p-6 rounded-2xl shadow-lg border border-slate-800">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-red-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs font-bold px-2 py-1 rounded-full bg-red-500/10 text-red-400 border border-red-500/20">Terlewat</span>
                    </div>
                    <h3 class="text-slate-400 text-sm font-medium uppercase">Tasks Overdue</h3>
                    <p class="text-3xl font-bold text-white mt-1">{{ $stats['overdue_tasks'] }}</p>
                </div>
            </div>

            {{-- Alert untuk overdue projects --}}
            @if($stats['overdue_projects'] > 0)
                <div class="mb-6 bg-red-500/10 border border-red-500/30 rounded-2xl p-4">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-red-300 mb-2">⚠️ Ada {{ $stats['overdue_projects'] }} Projects dengan Task Overdue!</h3>
                            <p class="text-sm text-red-200 mb-3">Project memiliki task yang terlewat deadline. Segera hubungi karyawan yang bertugas.</p>
                            <div class="space-y-1">
                                @foreach($overdueProjects as $project)
                                    <div class="flex items-center justify-between group hover:bg-red-500/5 rounded-lg px-2 py-1 transition-colors">
                                        <a href="{{ route('projects.show', $project) }}" class="flex items-center gap-2 text-sm text-red-300 hover:text-red-200 transition-colors">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                            <span>{{ $project->name }}</span>
                                            <span class="text-[11px] text-red-400">({{ $project->tasks->filter(function($task) { 
    return $task->status != 'completed' && \Carbon\Carbon::parse($task->due_date)->isPast(); 
})->count() }} tasks overdue)</span>
                                        </a>
                                        <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Hapus project ini? Semua tasks akan terhapus juga.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.86 13H5.86L5 7h14zm-4 0V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2h8z"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Alert untuk due soon tasks --}}
            @if($stats['due_soon_tasks'] > 0)
                <div class="mb-6 bg-yellow-500/10 border border-yellow-500/30 rounded-2xl p-4">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-yellow-300 mb-2">⚠️ {{ $stats['due_soon_tasks'] }} Tasks akan deadline dalam 3 hari!</h3>
                            <p class="text-sm text-yellow-200">Segera periksa dan pastikan tasks selesai tepat waktu.</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Projects Grid --}}
            @if($projects->isEmpty())
                <div class="text-center py-12 bg-slate-900 border border-slate-800 rounded-2xl">
                    <svg class="w-16 h-16 mx-auto text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    <p class="text-slate-400 text-lg mb-4">Belum ada project</p>
                    <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-2 px-6 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg font-bold transition-colors">
                        Buat Project Pertama
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($projects as $project)
                        <div class="group bg-slate-900 border border-slate-800 rounded-2xl p-6 hover:border-indigo-500/50 hover:shadow-xl transition-all">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <span class="text-[10px] text-slate-400 uppercase font-bold tracking-wide">Project</span>
                                    <h3 class="text-lg font-bold text-white group-hover:text-indigo-400 transition-colors">{{ $project->name }}</h3>
                                </div>
                                <div class="flex gap-1">
                                    <a href="{{ route('projects.edit', $project) }}" class="p-2 text-slate-400 hover:text-blue-400 hover:bg-blue-500/10 rounded-lg transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Hapus project ini? Semua tasks akan terhapus juga.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.86 13H5.86L5 7h14zm-4 0V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2h8z"></path></svg>
                                        </button>
                                    </form>
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
                                <a href="{{ route('projects.show', $project) }}" class="flex items-center gap-2 text-sm font-bold hover:text-indigo-400 transition-colors">
                                    <span>Lihat Detail</span>
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Pagination Links --}}
                @if($projects->hasPages())
                    <div class="flex justify-center mt-8">
                        {{ $projects->links('pagination::tailwind') }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>