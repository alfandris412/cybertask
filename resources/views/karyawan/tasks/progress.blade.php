<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-white tracking-tight">
                {{ __('Riwayat Progres Tugas') }}
            </h2>
            <a href="{{ route('tasks.show', $task) }}" class="text-slate-400 hover:text-white text-sm transition-colors">
                &larr; Kembali ke Detail Tugas
            </a>
        </div>
    </x-slot>

    <div class="py-6" x-data="progressModal()">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6">
                <p class="text-xs text-slate-400 uppercase font-bold mb-1">Tugas</p>
                <h1 class="text-lg md:text-2xl font-bold text-white mb-2">{{ $task->title }}</h1>
                <p class="text-sm text-slate-400 mb-4">Project: {{ $task->project->name }}</p>

                @php
                    $allProgressLogs = $task->comments
                        ->filter(function($c) { return $c->title; })
                        ->sortByDesc('created_at');
                    
                    $currentPage = request()->get('page', 1);
                    $perPage = 10;
                    $total = $allProgressLogs->count();
                    $offset = ($currentPage - 1) * $perPage;
                    $progressLogs = $allProgressLogs->slice($offset, $perPage)->values();
                @endphp

                @if($progressLogs->isEmpty())
                    <p class="text-slate-500 text-sm">Belum ada laporan progres untuk tugas ini.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-slate-300">
                            <thead class="bg-slate-800 border-b border-slate-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-[11px] font-bold text-slate-400 uppercase">No</th>
                                    <th class="px-4 py-3 text-left text-[11px] font-bold text-slate-400 uppercase">Judul</th>
                                    <th class="px-4 py-3 text-left text-[11px] font-bold text-slate-400 uppercase">Pelapor</th>
                                    <th class="px-4 py-3 text-left text-[11px] font-bold text-slate-400 uppercase">Tanggal</th>
                                    <th class="px-4 py-3 text-left text-[11px] font-bold text-slate-400 uppercase">Preview</th>
                                    <th class="px-4 py-3 text-center text-[11px] font-bold text-slate-400 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700/50">
                                @foreach($progressLogs as $index => $log)
                                    <tr class="hover:bg-slate-800/50 transition-colors">
                                        <td class="px-4 py-3 text-center font-bold text-emerald-400">{{ ($currentPage - 1) * $perPage + $index + 1 }}</td>
                                        <td class="px-4 py-3 font-semibold text-white">{{ $log->title }}</td>
                                        <td class="px-4 py-3 text-slate-300">{{ $log->user->name }}</td>
                                        <td class="px-4 py-3 text-slate-400 whitespace-nowrap">{{ $log->created_at->format('d M Y, H:i') }}</td>
                                        <td class="px-4 py-3 text-slate-200 truncate max-w-xs">{{ Str::limit($log->content, 80) }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <button type="button" @click="openDetail({{ ($currentPage - 1) * $perPage + $index + 1 }}, '{{ $log->title }}', '{{ $log->user->name }}', '{{ $log->created_at->format('d M Y, H:i') }}', `{{ addslashes($log->content) }}`)" class="px-3 py-1 bg-indigo-600 hover:bg-indigo-500 text-white text-[11px] font-bold rounded-lg transition-colors">
                                                Lihat
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Simple Pagination Links --}}
                    @if($total > $perPage)
                        <div class="flex justify-center items-center gap-2 mt-6">
                            @if($currentPage > 1)
                                <a href="{{ request()->url() }}?page={{ $currentPage - 1 }}" class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-white text-sm rounded-lg transition-colors">
                                    ←
                                </a>
                            @endif
                            
                            <span class="px-4 py-2 bg-slate-900 text-white text-sm rounded-lg">
                                Halaman {{ $currentPage }} dari {{ ceil($total / $perPage) }}
                            </span>
                            
                            @if($currentPage < ceil($total / $perPage))
                                <a href="{{ request()->url() }}?page={{ $currentPage + 1 }}" class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-white text-sm rounded-lg transition-colors">
                                    →
                                </a>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Modal Detail -->
        <div x-show="showModal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm" style="display: none;" x-transition>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-slate-900 border border-slate-800 rounded-2xl max-w-2xl w-full max-h-[80vh] overflow-y-auto shadow-2xl" @click.outside="closeDetail()">
                    <div class="sticky top-0 flex items-center justify-between px-6 py-4 border-b border-slate-800 bg-slate-900/95">
                        <div>
                            <p class="text-[11px] text-slate-400 uppercase font-bold tracking-wide">Laporan Progres #<span x-text="currentIndex"></span></p>
                            <h3 class="text-lg font-bold text-white" x-text="currentDetail.title"></h3>
                        </div>
                        <button @click="closeDetail()" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-800 text-slate-400 hover:bg-slate-700 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-slate-800/60 p-4 rounded-xl border border-slate-700">
                                <p class="text-[10px] text-slate-400 uppercase font-bold mb-1">Pelapor</p>
                                <p class="text-white font-semibold" x-text="currentDetail.user?.name"></p>
                            </div>
                            <div class="bg-slate-800/60 p-4 rounded-xl border border-slate-700">
                                <p class="text-[10px] text-slate-400 uppercase font-bold mb-1">Tanggal & Waktu</p>
                                <p class="text-white font-semibold" x-text="currentDetail.created_at"></p>
                            </div>
                        </div>

                        <div class="bg-slate-800/60 p-4 rounded-xl border border-slate-700">
                            <p class="text-[10px] text-slate-400 uppercase font-bold mb-2">Detail Laporan</p>
                            <p class="text-slate-200 leading-relaxed whitespace-pre-line text-sm" x-text="currentDetail.content"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function progressModal() {
            return {
                showModal: false,
                currentIndex: 0,
                currentDetail: {},

                openDetail(index, title, userName, createdAt, content) {
                    this.currentIndex = index;
                    this.currentDetail = {
                        title: title,
                        user: { name: userName },
                        created_at: createdAt,
                        content: content
                    };
                    this.showModal = true;
                },

                closeDetail() {
                    this.showModal = false;
                    setTimeout(() => {
                        this.currentDetail = {};
                        this.currentIndex = 0;
                    }, 300);
                }
            };
        }
    </script>
</x-app-layout>
