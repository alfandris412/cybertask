<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-xl text-white tracking-tight">
                {{ __('Detail Project') }}
            </h2>
            <a href="{{ route('projects.index') }}" class="inline-flex items-center text-slate-400 hover:text-white transition-colors text-sm font-medium group">
                <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-slate-900 border border-slate-800 shadow-2xl rounded-2xl overflow-hidden relative">
                 <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none"></div>
                 
                 <div class="p-6 md:p-8 relative z-10">
                    <div class="flex flex-col md:flex-row justify-between items-start gap-6">
                        <div class="flex-1">
                            <h1 class="text-2xl md:text-3xl font-bold text-white mb-3">{{ $project->name }}</h1>
                            <p class="text-slate-400 leading-relaxed text-sm md:text-base">{{ $project->description }}</p>
                        </div>
                        
                        <div class="flex flex-wrap gap-3 flex-shrink-0">
                            @if($project->repository_link)
                                <a href="{{ $project->repository_link }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-xl border border-slate-700 hover:border-slate-500 transition-all text-sm font-bold shadow-lg">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                    Repository
                                </a>
                            @endif

                            <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl shadow-lg shadow-indigo-500/30 transition-all text-sm font-bold">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit Project
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8 pt-8 border-t border-slate-800">
                        <div class="bg-slate-950/50 p-4 rounded-xl border border-slate-800 flex flex-col">
                            <span class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-1">Tanggal Mulai</span>
                            <span class="text-white font-mono">{{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }}</span>
                        </div>
                        <div class="bg-slate-950/50 p-4 rounded-xl border border-slate-800 flex flex-col">
                            <span class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-1">Target Selesai</span>
                            <span class="text-indigo-400 font-mono font-bold">{{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}</span>
                        </div>
                        <div class="bg-slate-950/50 p-4 rounded-xl border border-slate-800 flex flex-col justify-center">
                            <span class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-2">Status</span>
                            @php
                                $today = \Carbon\Carbon::now();
                                $end = \Carbon\Carbon::parse($project->end_date);
                            @endphp
                            @if($today > $end)
                                <span class="inline-flex self-start items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-500/10 text-red-400 border border-red-500/20">
                                    Overdue (Telat)
                                </span>
                            @else
                                <span class="inline-flex self-start items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20">
                                    On Progress
                                </span>
                            @endif
                        </div>
                    </div>
                 </div>
            </div>

            <div>
                <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Anggota Tim ({{ $project->members->count() }})
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($project->members as $member)
                    <div class="bg-slate-900 border border-slate-800 p-4 rounded-xl flex items-center gap-4 hover:border-indigo-500/50 transition-colors group">
                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-lg ring-2 ring-slate-800 group-hover:ring-indigo-500 transition-all overflow-hidden">
                            @if($member->avatar)
                                <img src="{{ asset('storage/' . $member->avatar) }}" class="h-full w-full object-cover" alt="{{ $member->name }}">
                            @else
                                {{ substr($member->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="min-w-0">
                            <div class="text-white font-bold group-hover:text-indigo-400 transition-colors truncate">{{ $member->name }}</div>
                            <div class="text-xs text-indigo-300 font-mono bg-indigo-500/10 px-2 py-0.5 rounded inline-block mt-1 border border-indigo-500/20">
                                {{ $member->pivot->role }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3 text-center py-8 border-2 border-dashed border-slate-800 rounded-xl text-slate-500 bg-slate-900/50">
                        Belum ada anggota tim. <a href="{{ route('projects.edit', $project) }}" class="text-indigo-400 hover:underline font-bold">Tambahkan sekarang</a>.
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="opacity-40 pointer-events-none filter blur-[1px]">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-white">Daftar Tugas</h3>
                </div>
                <div class="bg-slate-900 border border-slate-800 p-8 rounded-xl text-center text-slate-500">
                    <p>Fitur Manajemen Tugas akan kita buat di HARI 4.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>