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

    <div class="py-6" x-data="{ chatOpen: false }" @load="chatOpen = false">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            {{-- DETAIL TUGAS --}}
            <div class="bg-slate-900 border border-slate-800 shadow-2xl rounded-2xl overflow-hidden p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
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
                        <h1 class="text-2xl md:text-3xl font-bold text-white leading-tight">{{ $task->title }}</h1>
                    </div>
                </div>

                <div class="prose prose-invert max-w-none text-slate-300 text-sm leading-relaxed bg-slate-950/40 p-4 rounded-xl border border-slate-800">
                    {!! nl2br(e($task->description)) !!}
                </div>

                @php
                    $todayReports = $task->comments->filter(function($c) {
                        return $c->title && $c->created_at->isToday();
                    });
                @endphp

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-slate-800/60 p-4 rounded-xl border border-slate-700 flex items-center gap-4">
                        <div class="p-3 rounded-lg bg-slate-700 text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Deadline</p>
                            <p class="text-white font-mono text-sm">{{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</p>
                            <p class="text-[11px] text-slate-500 mt-1">Dibuat: {{ $task->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <div class="bg-slate-800/60 p-4 rounded-xl border border-slate-700 flex flex-col gap-2">
                        <div class="flex items-center justify-between">
                            <p class="text-[10px] text-slate-400 font-bold uppercase">Prioritas</p>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-900/80 border border-slate-700 text-slate-300">Komentar: {{ $task->comments->count() }}</span>
                        </div>
                        <div>
                            @if($task->priority == 'high')
                                <span class="text-red-400 font-bold text-sm">High 🔥</span>
                            @elseif($task->priority == 'medium')
                                <span class="text-yellow-400 font-bold text-sm">Medium ⚠️</span>
                            @else
                                <span class="text-green-400 font-bold text-sm">Low ☕</span>
                            @endif
                        </div>
                        <div class="text-[11px] text-slate-400 flex flex-wrap gap-2 mt-1">
                            <span class="px-2 py-0.5 rounded-full bg-slate-900/80 border border-slate-700">Anggota: {{ $task->users->count() }}</span>
                            @if($todayReports->count() > 0)
                                <span class="px-2 py-0.5 rounded-full bg-emerald-900/50 border border-emerald-500/40 text-emerald-300">Progres Hari Ini: {{ $todayReports->count() }}</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-slate-900/80 border border-slate-700">Belum ada progres hari ini</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- TIM BERTUGAS --}}
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6">
                <h3 class="text-sm font-bold text-slate-200 mb-3">Tim Bertugas ({{ $task->users->count() }})</h3>
                @if($task->usersWithProjectRole->isEmpty())
                    <p class="text-slate-500 text-sm">Belum ada anggota yang ditugaskan.</p>
                @else
                    @php
                        $groupedUsers = $task->usersWithProjectRole->groupBy(function($user) {
                            return $user->project_role ?? 'Member';
                        });
                    @endphp
                    
                    <div class="space-y-3 mb-4">
                        @forelse($groupedUsers as $position => $users)
                            <div class="bg-slate-800/50 rounded-xl p-3 border border-slate-700/50">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-6 h-6 rounded-full bg-indigo-600/20 flex items-center justify-center text-indigo-400 text-[8px] font-bold">
                                        {{ substr($position, 0, 1) }}
                                    </div>
                                    <h4 class="text-xs font-bold text-indigo-300 uppercase">{{ $position }}</h4>
                                    <span class="text-[9px] text-slate-500">({{ $users->count() }} orang)</span>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($users as $member)
                                        <div class="flex items-center gap-2 px-3 py-2 rounded-xl bg-slate-900/70 border border-slate-700/70">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                                {{ substr($member->name, 0, 1) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs font-semibold text-white truncate">{{ $member->name }}</p>
                                                <p class="text-[10px] text-slate-400 truncate">{{ $member->project_role ?? 'Member' }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-500 text-sm italic">Belum ada tim.</p>
                        @endforelse
                    </div>
                @endif
            </div>

            {{-- RIWAYAT PROGRES (3 TERBARU) --}}
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-bold text-slate-200">Riwayat Progres</h3>
                    <a href="{{ route('tasks.progress', $task) }}" class="text-[11px] text-indigo-400 hover:text-indigo-300">Lihat semua &rarr;</a>
                </div>

                @php
                    $progressLogs = $task->comments
                        ->filter(function($c) { return $c->title; })
                        ->sortByDesc('created_at')
                        ->take(3);
                @endphp

                @if($progressLogs->isEmpty())
                    <p class="text-slate-500 text-sm">Belum ada laporan progres untuk tugas ini.</p>
                @else
                    <div class="space-y-3">
                        @foreach($progressLogs as $log)
                            <div class="border border-slate-700/70 rounded-xl p-3 bg-slate-800/60">
                                <div class="flex items-start justify-between mb-1">
                                    <div>
                                        <p class="text-[11px] font-bold text-emerald-400 uppercase">{{ $log->title }}</p>
                                        <p class="text-[11px] text-slate-300">Oleh: {{ $log->user->name }}</p>
                                    </div>
                                    <span class="text-[10px] text-slate-500">{{ $log->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <p class="text-xs text-slate-200 leading-relaxed whitespace-pre-line">{{ $log->content }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- PANEL LAPOR PROGRES UNTUK KARYAWAN --}}
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6" x-data="progressForm()">
                <h3 class="text-sm font-bold text-white mb-4">Lapor Progres & Commit</h3>
                <form action="{{ route('tasks.update-status', $task) }}" method="POST" class="space-y-4" @submit.prevent="submitProgress($event)">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="text-xs text-slate-400 font-bold mb-1 block uppercase">Judul Laporan</label>
                        <input type="text" name="report_title" x-ref="reportTitle" class="w-full bg-slate-950 border-slate-700 text-white rounded-xl focus:ring-indigo-500 p-3 text-sm" placeholder="Contoh: Fix Login Bug" required :disabled="isSubmitting">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-slate-400 font-bold mb-1 block uppercase">Update Status</label>
                            <select name="status" x-ref="statusSelect" class="w-full bg-slate-950 border-slate-700 text-white rounded-xl focus:ring-indigo-500 p-3 text-sm" :disabled="isSubmitting">
                                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>🚀 Sedang Dikerjakan</option>
                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>✅ Selesai</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs text-slate-400 font-bold mb-1 block uppercase">Link Commit GitHub</label>
                            <input type="url" name="github_link" x-ref="githubLink" value="{{ $task->github_link }}" class="w-full bg-slate-950 border-slate-700 text-white rounded-xl focus:ring-indigo-500 p-3 text-sm" placeholder="https://github.com/user/repo/commit/..." :disabled="isSubmitting">
                        </div>
                    </div>

                    <div>
                        <label class="text-xs text-slate-400 font-bold mb-1 block uppercase">Detail Pengerjaan</label>
                        <textarea name="report_desc" x-ref="reportDesc" rows="3" class="w-full bg-slate-950 border-slate-700 text-white rounded-xl focus:ring-indigo-500 p-3 text-sm" placeholder="Apa yang sudah dikerjakan..." required :disabled="isSubmitting"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg text-sm transition-all" :disabled="isSubmitting">
                        <span x-show="!isSubmitting">Kirim Laporan & Update</span>
                        <span x-show="isSubmitting">Mengirim...</span>
                    </button>
                </form>
            </div>

            {{-- CHAT / DISKUSI (BUTTON + POPUP) --}}
            <div class="flex justify-end">
                <button @click="chatOpen = true" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 border border-slate-700 text-slate-100 rounded-xl text-sm hover:bg-slate-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.51 15.683 3 13.9 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    <span> Buka Timeline &amp; Diskusi</span>
                </button>
            </div>

            <!-- Popup Chat -->
            <div x-show="chatOpen" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm" style="display: none;" x-transition @click.outside="chatOpen = false">
                <div class="absolute inset-x-0 bottom-0 md:bottom-6 md:right-6 md:left-auto md:w-[420px] h-[75vh] md:h-[600px] bg-slate-950 border border-slate-800 rounded-t-2xl md:rounded-2xl shadow-2xl flex flex-col overflow-hidden" @click.stop>
                    <div class="flex-shrink-0 flex items-center justify-between px-4 py-3 border-b border-slate-800 bg-slate-900/95">
                        <div>
                            <p class="text-[11px] text-slate-400 uppercase font-bold tracking-wide">Timeline &amp; Diskusi</p>
                            <p class="text-xs text-slate-300 truncate">{{ $task->title }}</p>
                        </div>
                        <button @click="chatOpen = false" class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-800 text-slate-300 hover:bg-slate-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div id="chatContainer" class="flex-1 overflow-y-auto space-y-4 p-4 pr-2">
                        <div id="messagesWrapper">
                            @forelse($task->comments as $comment)
                                @if($comment->title)
                                    <div class="bg-slate-800/60 border border-emerald-500/30 rounded-xl p-4 text-sm text-slate-100">
                                        <div class="flex justify-between items-start mb-1">
                                            <span class="text-xs font-bold text-emerald-400 uppercase">Laporan Progres</span>
                                            <span class="text-[10px] text-slate-500">{{ $comment->created_at->format('d M, H:i') }}</span>
                                        </div>
                                        <h4 class="font-semibold mb-1">{{ $comment->title }}</h4>
                                        <p class="text-slate-200 text-sm leading-relaxed">{!! nl2br(e($comment->content)) !!}</p>
                                        <p class="mt-1 text-[11px] text-slate-400">Oleh: {{ $comment->user->name }}</p>
                                    </div>
                                @else
                                    <div class="flex gap-2 {{ $comment->user_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                                        <div class="w-8 h-8 rounded-full flex-shrink-0 {{ $comment->user_id === auth()->id() ? 'bg-indigo-600' : 'bg-slate-700' }} flex items-center justify-center text-white text-xs font-bold">
                                            {{ substr($comment->user->name, 0, 1) }}
                                        </div>
                                        <div class="max-w-[80%] flex flex-col {{ $comment->user_id === auth()->id() ? 'items-end' : 'items-start' }}">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="text-[11px] font-semibold {{ $comment->user_id === auth()->id() ? 'text-indigo-300' : 'text-slate-200' }}">{{ $comment->user->name }}</span>
                                                <span class="text-[10px] text-slate-500">{{ $comment->created_at->format('d M, H:i') }}</span>
                                            </div>
                                            <div class="px-3 py-2 rounded-2xl text-sm {{ $comment->user_id === auth()->id() ? 'bg-indigo-600 text-white rounded-br-none' : 'bg-slate-800 text-slate-100 rounded-bl-none border border-slate-700' }}">
                                                @if($comment->attachment)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/' . $comment->attachment) }}" class="w-40 h-28 object-cover rounded-lg border border-slate-700">
                                                    </div>
                                                @endif
                                                @if($comment->content)
                                                    <p class="leading-relaxed break-words">{{ $comment->content }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div id="emptyState" class="text-center text-slate-500 text-sm py-6">Belum ada diskusi.</div>
                            @endforelse
                        </div>
                    </div>

                    <div x-data="chatForm()" class="flex-shrink-0 border-t border-slate-800 px-3 py-3 bg-slate-900/98">
                        <form action="{{ route('comments.store') }}" method="POST" enctype="multipart/form-data" class="flex items-end gap-2" @submit.prevent="submitComment($event)">
                            @csrf
                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                            <input type="file" name="attachment" id="attachment" class="hidden" x-ref="photo" accept="image/*" @change="handleFileChange($event)">

                            <button type="button" class="p-2.5 bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white rounded-xl border border-slate-700" @click="$refs.photo.click()">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                            </button>

                            <input type="text" name="content" x-ref="messageInput" class="flex-1 px-3 py-2.5 rounded-xl border-slate-700 bg-slate-950 text-white text-sm focus:ring-indigo-500" placeholder="Ketik pesan..." autocomplete="off" :disabled="isSubmitting">

                            <button type="submit" class="p-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl shadow-md" :disabled="isSubmitting">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!isSubmitting"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function chatForm() {
            return {
                photoPreview: null,
                isSubmitting: false,
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
                                contentHTML += `<div class="mb-2"><img src="${this.photoPreview}" class="w-40 h-28 object-cover rounded-lg border border-slate-700"></div>`;
                            }
                            if (messageText) {
                                const div = document.createElement('div');
                                div.textContent = messageText;
                                contentHTML += `<p class="leading-relaxed break-words">${div.innerHTML}</p>`;
                            }

                            const wrapper = document.getElementById('messagesWrapper');
                            wrapper.insertAdjacentHTML('beforeend', `
                                <div class="flex gap-2 flex-row-reverse">
                                    <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xs font-bold">${this.userInitial}</div>
                                    <div class="max-w-[80%] flex flex-col items-end">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-[11px] font-semibold text-indigo-300">${this.userName}</span>
                                            <span class="text-[10px] text-slate-500">${timeStr}</span>
                                        </div>
                                        <div class="px-3 py-2 rounded-2xl text-sm bg-indigo-600 text-white rounded-br-none">
                                            ${contentHTML}
                                        </div>
                                    </div>
                                </div>
                            `);

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
            if (chatContainer) {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        });

        function progressForm() {
            return {
                isSubmitting: false,

                async submitProgress(event) {
                    if (this.isSubmitting) return;

                    const form = event.target.closest('form');
                    const formData = new FormData(form);

                    this.isSubmitting = true;

                    try {
                        const response = await fetch(form.action, {
                            method: 'PUT',
                            body: formData,
                            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                        });

                        const data = await response.json();

                        if (response.ok) {
                            // Show success message
                            const successMsg = document.createElement('div');
                            successMsg.className = 'fixed top-4 right-4 bg-emerald-600 text-white px-6 py-3 rounded-xl shadow-lg z-50 animate-bounce';
                            successMsg.textContent = '✅ Laporan berhasil dikirim!';
                            document.body.appendChild(successMsg);

                            // Clear form
                            this.$refs.reportTitle.value = '';
                            this.$refs.reportDesc.value = '';
                            this.$refs.githubLink.value = '';
                            this.$refs.statusSelect.value = 'pending';

                            // Remove success message after 3 seconds
                            setTimeout(() => successMsg.remove(), 3000);
                        } else {
                            alert('Gagal: ' + (data.message || 'Error server.'));
                        }
                    } catch (error) {
                        console.error(error);
                        alert('Gagal mengirim laporan.');
                    } finally {
                        this.isSubmitting = false;
                    }
                }
            };
        }
    </script>
</x-app-layout>
