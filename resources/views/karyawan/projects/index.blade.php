<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white tracking-tight">
            {{ __('My Projects') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($projects->isEmpty())
                <div class="text-center py-12 bg-slate-900 border border-slate-800 rounded-2xl">
                    <svg class="w-16 h-16 mx-auto text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    <p class="text-slate-400 text-lg">Belum ada project yang Anda ikuti</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($projects as $project)
                        <div class="group bg-slate-900 border border-slate-800 rounded-2xl p-6 hover:border-indigo-500/50 hover:shadow-xl transition-all">
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
                                <a href="{{ route('projects.show', $project) }}" class="flex items-center gap-2 text-sm font-bold">
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
