<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-white tracking-tight">
                {{ __('Ruang Kerja & Diskusi') }}
            </h2>
            <a href="{{ route('projects.show', $task->project) }}" class="text-slate-400 hover:text-white transition-colors text-sm">
                &larr; Kembali ke Project
            </a>
        </div>
    </x-slot>

    <style>
        /* Custom Scrollbar agar terlihat modern */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #0f172a; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 3px; }
        
        /* Animasi Chat Masuk */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.3s ease-out forwards; }
    </style>

    <div class="py-8" x-data="{ chatOpen: false }" @load="chatOpen = false"> 
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="flex flex-col gap-6 pb-8 max-w-5xl">
                    
                    <div class="bg-slate-900 border border-slate-800 shadow-2xl rounded-2xl overflow-hidden p-8 relative">
                        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
                        
                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-6">
                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1 rounded-lg text-[10px] font-bold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 uppercase tracking-wide">
                                        {{ $task->project->name }}
                                    </span>
                                    
                                    @if($task->status == 'completed')
                                        <span class="px-3 py-1 rounded-lg text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 uppercase">Selesai</span>
                                    @elseif($task->status == 'in_progress')
                                        <span class="px-3 py-1 rounded-lg text-[10px] font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20 uppercase">Proses</span>
                                    @else
                                        <span class="px-3 py-1 rounded-lg text-[10px] font-bold bg-slate-700 text-slate-300 border border-slate-600 uppercase">Pending</span>
                                    @endif
                                </div>
                                
                                <div class="flex gap-2">
                                    @if($task->github_link)
                                        <a href="{{ $task->github_link }}" target="_blank" class="p-2 rounded-lg bg-slate-800 hover:bg-gray-700 text-white border border-slate-700 transition-all" title="Lihat Commit GitHub">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                        </a>
                                    @endif

                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('tasks.edit', $task) }}" class="p-2 rounded-lg bg-slate-800 hover:bg-indigo-600 text-slate-400 hover:text-white transition-all border border-slate-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <h1 class="text-3xl md:text-4xl font-bold text-white mb-6 leading-tight">{{ $task->title }}</h1>
                            
                            <div class="prose prose-invert max-w-none text-slate-300 text-base leading-relaxed bg-slate-950/50 p-6 rounded-2xl border border-slate-800 shadow-inner">
                                {!! nl2br(e($task->description)) !!}
                            </div>

                            @php
                                $todayReportsLeft = $task->comments->filter(function($c) {
                                    return $c->title && $c->created_at->isToday();
                                });
                            @endphp

                            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-slate-800/50 p-4 rounded-xl border border-slate-700/50 flex items-center gap-4">
                                    <div class="p-3 rounded-lg bg-slate-700 text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                                    <div>
                                        <p class="text-[10px] text-slate-500 uppercase font-bold mb-1">Deadline</p>
                                        <p class="text-white font-mono text-sm md:text-lg">{{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</p>
                                        <p class="text-[11px] text-slate-500 mt-1">Dibuat: {{ $task->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                                <div class="bg-slate-800/50 p-4 rounded-xl border border-slate-700/50 flex items-center gap-4">
                                    <div class="p-3 rounded-lg bg-slate-700 text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></div>
                                    <div>
                                        <p class="text-[10px] text-slate-500 uppercase font-bold mb-1">Prioritas</p>
                                        @if($task->priority == 'high')
                                            <span class="text-red-400 font-bold text-sm md:text-lg">High 🔥</span>
                                        @elseif($task->priority == 'medium')
                                            <span class="text-yellow-400 font-bold text-sm md:text-lg">Medium ⚠️</span>
                                        @else
                                            <span class="text-green-400 font-bold text-sm md:text-lg">Low ☕</span>
                                        @endif

                                        <div class="mt-2 flex flex-wrap gap-2 text-[11px] text-slate-400">
                                            <span class="px-2 py-0.5 rounded-full bg-slate-900/70 border border-slate-700/70">Komentar: {{ $task->comments->count() }}</span>
                                            <span class="px-2 py-0.5 rounded-full bg-slate-900/70 border border-slate-700/70">Anggota: {{ $task->users->count() }}</span>
                                            @if($todayReportsLeft->count() > 0)
                                                <span class="px-2 py-0.5 rounded-full bg-emerald-900/40 border border-emerald-500/40 text-emerald-300">Progres Hari Ini: {{ $todayReportsLeft->count() }}</span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-full bg-slate-900/70 border border-slate-700/70">Belum ada progres hari ini</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->role === 'karyawan')
                    <div class="bg-gradient-to-br from-slate-900 to-slate-800 border border-indigo-500/30 shadow-lg rounded-2xl p-6 relative overflow-hidden">
                        
                        <div class="absolute top-0 right-0 p-4 opacity-10 pointer-events-none">
                            <svg class="w-32 h-32 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        
                        <h3 class="text-lg font-bold text-white mb-4 relative z-10 flex items-center gap-2">
                            <span class="flex h-3 w-3 relative"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span><span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span></span>
                            Lapor Progres & Commit
                        </h3>
                        
                        <form action="{{ route('tasks.update-status', $task) }}" method="POST" class="relative z-10 space-y-4">
                            @csrf
                            @method('PUT')
                            
                            <div>
                                <label class="text-xs text-indigo-300 font-bold mb-1 block uppercase">Judul Laporan</label>
                                <input type="text" name="report_title" class="w-full bg-slate-950 border-slate-700 text-white rounded-xl focus:ring-indigo-500 p-3" placeholder="Contoh: Fix Login Bug" required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs text-indigo-300 font-bold mb-1 block uppercase">Update Status</label>
                                    <select name="status" class="w-full bg-slate-950 border-slate-700 text-white rounded-xl focus:ring-indigo-500 p-3">
                                        <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                        <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>🚀 Sedang Dikerjakan</option>
                                        <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>✅ Selesai</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs text-indigo-300 font-bold mb-1 block uppercase">Link Commit GitHub</label>
                                    <input type="url" name="github_link" value="{{ $task->github_link }}" class="w-full bg-slate-950 border-slate-700 text-white rounded-xl focus:ring-indigo-500 p-3" placeholder="https://github.com/user/repo/commit/...">
                                </div>
                            </div>

                            <div>
                                <label class="text-xs text-indigo-300 font-bold mb-1 block uppercase">Detail Pengerjaan</label>
                                <textarea name="report_desc" rows="3" class="w-full bg-slate-950 border-slate-700 text-white rounded-xl focus:ring-indigo-500 p-3" placeholder="Apa yang sudah dikerjakan..." required></textarea>
                            </div>

                            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg transition-all transform active:scale-95">
                                Kirim Laporan & Update
                            </button>
                        </form>
                    </div>
                    @endif

                    <div class="bg-slate-900 border border-slate-800 shadow-lg rounded-2xl p-6">
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Tim Bertugas ({{ $task->users->count() }})
                        </h3>
                        
                        <!-- Avatar Stack -->
                        <div class="flex items-center -space-x-3 mb-4">
                            @forelse($task->users as $member)
                                <div class="group relative">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-white text-xs font-bold shadow-md ring-2 ring-slate-900 hover:ring-indigo-500 transition-all cursor-pointer hover:scale-110 hover:z-10"
                                         title="{{ $member->name }}">
                                        {{ substr($member->name, 0, 2) }}
                                    </div>
                                    <!-- Tooltip on hover -->
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-slate-800 text-white text-xs rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity z-20 pointer-events-none border border-slate-700">
                                        <div class="font-bold">{{ $member->name }}</div>
                                        <div class="text-slate-400">{{ $member->pivot->role ?? 'Member' }}</div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-slate-500 text-sm italic">Belum ada tim.</p>
                            @endforelse
                        </div>
                        
                        <!-- Full list below stack -->
                        <div class="pt-4 border-t border-slate-700">
                            <p class="text-xs text-slate-500 font-bold uppercase mb-3">Daftar Lengkap:</p>
                            <div class="space-y-2">
                                @forelse($task->users as $member)
                                    <div class="flex items-center gap-2 p-2 rounded-lg bg-slate-800/50 border border-slate-700/50 hover:border-indigo-500/50 transition-colors">
                                        <div class="w-6 h-6 rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-white text-[10px] font-bold flex-shrink-0">
                                            {{ substr($member->name, 0, 1) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-bold text-white truncate">{{ $member->name }}</p>
                                            <p class="text-[10px] text-indigo-400 truncate">{{ $member->email }}</p>
                                        </div>
                                        <span class="text-[9px] text-slate-500 whitespace-nowrap">{{ $member->pivot->role ?? 'Member' }}</span>
                                    </div>
                                @empty
                                    <p class="text-slate-500 text-sm italic">Belum ada tim.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    
                    {{-- PROGRESS HISTORY (UNTUK SEMUA) --}}
                    <div class="bg-slate-900 border border-slate-800 shadow-lg rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Riwayat Progres
                            </h3>
                            <a href="{{ route('tasks.progress', $task) }}" class="text-[11px] text-indigo-400 hover:text-indigo-300 font-semibold">Lihat Semua &rarr;</a>
                        </div>

                        @php
                            $progressLogs = $task->comments
                                ->filter(function($c) { return $c->title; })
                                ->sortByDesc('created_at')
                                ->take(5);
                        @endphp

                        @if($progressLogs->isEmpty())
                            <p class="text-slate-500 text-sm italic">Belum ada laporan progres untuk tugas ini.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($progressLogs as $log)
                                    <div class="border border-slate-700/50 rounded-xl p-4 bg-slate-800/40 hover:bg-slate-800/60 transition-colors">
                                        <div class="flex items-start justify-between mb-2">
                                            <div>
                                                <p class="text-[11px] font-bold text-emerald-400 uppercase">{{ $log->title }}</p>
                                                <p class="text-[11px] text-slate-400 mt-1">Oleh: <span class="text-slate-200">{{ $log->user->name }}</span></p>
                                            </div>
                                            <span class="text-[10px] text-slate-500 whitespace-nowrap">{{ $log->created_at->format('d M, H:i') }}</span>
                                        </div>
                                        <p class="text-sm text-slate-300 leading-relaxed whitespace-pre-line line-clamp-2">{{ $log->content }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    
                    {{-- CHAT BUTTON --}}
                    <div class="flex justify-end">
                        <button @click="chatOpen = true" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 border border-slate-700 text-slate-100 rounded-xl text-sm hover:bg-slate-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.51 15.683 3 13.9 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            <span>Buka Timeline & Diskusi</span>
                        </button>
                    </div>
            </div>

            {{-- CHAT MODAL POPUP --}}
            <div x-show="chatOpen" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm" style="display: none;" x-transition @click.outside="chatOpen = false">
                <div class="absolute inset-x-0 bottom-0 md:bottom-6 md:right-6 md:left-auto md:w-[420px] h-[75vh] md:h-[600px] bg-slate-950 border border-slate-800 rounded-t-2xl md:rounded-2xl shadow-2xl flex flex-col overflow-hidden" @click.stop>
                    <div class="flex-shrink-0 flex items-center justify-between px-4 py-3 border-b border-slate-800 bg-slate-900/95">
                        <div>
                            <p class="text-[11px] text-slate-400 uppercase font-bold tracking-wide">Timeline & Diskusi</p>
                            <p class="text-xs text-slate-300 truncate">{{ $task->title }}</p>
                        </div>
                        <button @click="chatOpen = false" class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-800 text-slate-300 hover:bg-slate-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div id="chatContainer" class="flex-1 overflow-y-auto space-y-4 p-4 pr-2 custom-scrollbar">
                        <div id="messagesWrapper">
                                @forelse($task->comments as $comment)
                                    
                                    @if($comment->title)
                                        <div class="flex gap-3 animate-fade-in-up">
                                            <div class="flex-col items-center hidden md:flex">
                                                <div class="w-8 h-8 rounded-full bg-green-600 flex items-center justify-center text-white text-xs font-bold ring-4 ring-slate-900 z-10">L</div>
                                                <div class="h-full w-0.5 bg-slate-800 -mt-2"></div>
                                            </div>
                                            <div class="flex-1">
                                                <div class="bg-slate-800/50 border border-green-500/30 rounded-xl p-4">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <span class="text-xs font-bold text-green-400 uppercase">Laporan Progres</span>
                                                        <span class="text-[10px] text-slate-500">{{ $comment->created_at->format('d M, H:i') }}</span>
                                                    </div>
                                                    <h4 class="text-white font-bold text-sm mb-1">{{ $comment->title }}</h4>
                                                    <p class="text-slate-300 text-sm leading-relaxed">{!! nl2br(e($comment->content)) !!}</p>
                                                    <div class="mt-2 text-xs text-slate-500">Oleh: <span class="text-slate-300">{{ $comment->user->name }}</span></div>
                                                </div>
                                            </div>
                                        </div>

                                    @else
                                        <div class="flex gap-3 {{ $comment->user_id === Auth::id() ? 'flex-row-reverse' : '' }} mb-4 group">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $comment->user_id === Auth::id() ? 'bg-indigo-600' : 'bg-slate-700' }} flex items-center justify-center text-white text-xs font-bold ring-2 ring-slate-900 shadow-lg self-end mb-1">
                                                {{ substr($comment->user->name, 0, 1) }}
                                            </div>
                                            <div class="max-w-[85%] flex flex-col {{ $comment->user_id === Auth::id() ? 'items-end' : 'items-start' }}">
                                                <div class="flex items-center gap-2 mb-1 px-1">
                                                    <span class="text-[10px] font-bold {{ $comment->user_id === Auth::id() ? 'text-indigo-400' : 'text-slate-300' }}">{{ $comment->user->name }}</span>
                                                    <span class="text-[9px] text-slate-500 px-2 py-0.5 rounded-full bg-slate-800/80 border border-slate-700/70">
                                                        {{ ucfirst($comment->user->role ?? 'member') }}
                                                    </span>
                                                    <span class="text-[9px] text-slate-600">{{ $comment->created_at->format('d M, H:i') }}</span>
                                                </div>
                                                <div class="relative px-4 py-3 rounded-2xl text-sm shadow-md {{ $comment->user_id === Auth::id() ? 'bg-indigo-600 text-white rounded-br-none' : 'bg-slate-800 text-slate-200 rounded-bl-none border border-slate-700' }}">
                                                    
                                                    @if($comment->attachment)
                                                        <div class="mb-2 -mx-2 -mt-2 cursor-pointer" @click="lightboxOpen = true; lightboxImage = '{{ asset('storage/' . $comment->attachment) }}'">
                                                            <div class="overflow-hidden rounded-t-xl border-b border-white/10">
                                                                <img src="{{ asset('storage/' . $comment->attachment) }}" class="w-48 h-32 object-cover hover:scale-105 transition-transform duration-500">
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($comment->content)<p class="leading-relaxed break-words">{{ $comment->content }}</p>@endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @empty
                                    <div class="text-center opacity-50 py-12" id="emptyState"><p class="text-slate-400 text-sm">Belum ada diskusi.</p></div>
                                @endforelse
                            </div>
                        </div>

                        <div class="p-3 border-t border-slate-800 bg-slate-900 flex-shrink-0 z-20 relative" x-data="chatForm()">
                            
                            <div class="absolute bottom-full left-0 mb-2 ml-4" x-show="photoPreview" style="display: none;" x-transition>
                                <div class="relative inline-block group">
                                    <img :src="photoPreview" class="h-20 w-20 object-cover rounded-xl border-2 border-indigo-500 shadow-lg bg-slate-800">
                                    <button type="button" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full p-1 shadow-lg hover:bg-red-600" @click="clearPhoto()"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                </div>
                            </div>

                            <form action="{{ route('comments.store') }}" method="POST" enctype="multipart/form-data" class="flex items-end gap-2" @submit.prevent="submitComment($event)">
                                @csrf
                                <input type="hidden" name="task_id" value="{{ $task->id }}">
                                <input type="file" name="attachment" id="attachment" class="hidden" x-ref="photo" accept="image/*" @change="handleFileChange($event)">
                                
                                <button type="button" class="p-2.5 bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white rounded-xl border border-slate-700" @click="$refs.photo.click()"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg></button>
                                
                                <input type="text" name="content" x-ref="messageInput" class="flex-1 px-4 py-3 rounded-xl border-slate-700 bg-slate-950 text-white text-sm focus:ring-indigo-500" placeholder="Ketik pesan..." autocomplete="off" :disabled="isSubmitting">
                                
                                <button type="submit" class="p-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl" :disabled="isSubmitting"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!isSubmitting"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="lightboxOpen" style="display: none;" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/95 backdrop-blur-sm p-4" x-transition @click="lightboxOpen = false">
            <div class="relative max-w-5xl max-h-full" @click.stop>
                <img :src="lightboxImage" class="max-w-full max-h-[90vh] rounded-lg shadow-2xl border border-white/10">
                <button class="absolute -top-12 right-0 text-white hover:text-red-400 p-2" @click="lightboxOpen = false"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
        </div>
    </div>

    <script>
        function chatForm() {
            return {
                photoPreview: null,
                isSubmitting: false,
                // FIX JAVASCRIPT AMAN (pakai helper Blade Js::from untuk aman)
                userName: {!! Js::from(Auth::user()->name) !!},
                userInitial: {!! Js::from(substr(Auth::user()->name, 0, 1)) !!},
                
                handleFileChange(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => { this.photoPreview = e.target.result; };
                        reader.readAsDataURL(file);
                    }
                },
                
                clearPhoto() {
                    this.photoPreview = null;
                    this.$refs.photo.value = '';
                },
                
                async submitComment(event) {
                    if (this.isSubmitting) return;
                    
                    const form = event.target.closest('form');
                    const formData = new FormData(form);
                    const messageText = this.$refs.messageInput.value.trim();
                    const hasFile = this.$refs.photo.files.length > 0;
                    
                    if (!messageText && !hasFile) return;
                    
                    this.isSubmitting = true;
                    
                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                        });
                        
                        const data = await response.json();

                        if (response.ok) {
                            const emptyState = document.getElementById('emptyState');
                            if (emptyState) emptyState.remove();
                            
                            const now = new Date();
                            const timeStr = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
                            
                            let contentHTML = '';
                            if (hasFile && this.photoPreview) {
                                contentHTML += `<div class="mb-2 -mx-2 -mt-2"><div class="overflow-hidden rounded-t-xl border-b border-white/10"><img src="${this.photoPreview}" class="w-48 h-32 object-cover"></div></div>`;
                            }
                            if (messageText) {
                                const div = document.createElement('div');
                                div.textContent = messageText;
                                contentHTML += `<p class="leading-relaxed break-words">${div.innerHTML}</p>`;
                            }
                            
                            const messageHTML = `
                                <div class="flex gap-3 flex-row-reverse mb-4 animate-fade-in-up">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xs font-bold ring-2 ring-slate-900 shadow-lg self-end mb-1">${this.userInitial}</div>
                                    <div class="max-w-[80%] flex flex-col items-end">
                                        <div class="flex items-center gap-2 mb-1 px-1">
                                            <span class="text-[10px] font-bold text-indigo-400">${this.userName}</span>
                                            <span class="text-[9px] text-slate-600">${timeStr}</span>
                                        </div>
                                        <div class="relative px-4 py-3 rounded-2xl text-sm shadow-md bg-indigo-600 text-white rounded-br-none">
                                            ${contentHTML}
                                        </div>
                                    </div>
                                </div>`;
                            
                            document.getElementById('messagesWrapper').insertAdjacentHTML('beforeend', messageHTML);
                            const chatContainer = document.getElementById('chatContainer');
                            chatContainer.scrollTop = chatContainer.scrollHeight;
                            
                            this.$refs.messageInput.value = '';
                            this.clearPhoto();
                        } else {
                            alert('Gagal: ' + (data.message || 'Error server.'));
                        }
                    } catch (error) {
                        console.error(error);
                        alert('Gagal mengirim pesan.');
                    } finally {
                        this.isSubmitting = false;
                    }
                }
            };
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const chatContainer = document.getElementById('chatContainer');
            if(chatContainer) chatContainer.scrollTop = chatContainer.scrollHeight;
        });
    </script>
</x-app-layout>