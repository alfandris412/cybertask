<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <a href="{{ auth()->user()->role === 'admin' ? route('dashboard') : route('dashboard') }}" class="text-slate-400 hover:text-white text-sm mb-2 inline-block transition-colors">
                    &larr; Kembali
                </a>
                <h2 class="font-bold text-xl text-white tracking-tight">
                    {{ $project->name }}
                </h2>
            </div>
            @if(auth()->user()->role === 'admin')
                <div class="flex gap-2">
                    <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-xl text-sm font-bold transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Project
                    </a>
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Hapus project ini? Semua tasks dan data akan terhapus permanen!')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-xl text-sm font-bold transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.86 13H5.86L5 7h14zm-4 0V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2h8z"></path></svg>
                            Hapus Project
                        </button>
                    </form>
                    <a href="{{ route('projects.tasks.create', $project) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-bold transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Task
                    </a>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Project Info --}}
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-xs text-slate-400 uppercase font-bold mb-1">Deskripsi</p>
                        <p class="text-slate-300">{{ $project->description ?? 'Tidak ada deskripsi' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase font-bold mb-1">Total Tasks</p>
                        <p class="text-2xl font-bold text-indigo-400">{{ $project->tasks()->count() }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase font-bold mb-1">Selesai</p>
                        <p class="text-2xl font-bold text-emerald-400">{{ $project->tasks()->where('status', 'completed')->count() }} / {{ $project->tasks()->count() }}</p>
                    </div>
                </div>
            </div>

            {{-- Tasks Table --}}
            <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-800 bg-slate-900/50">
                    <h3 class="text-sm font-bold text-slate-200">Daftar Tasks</h3>
                </div>

                @if($tasks->isEmpty())
                    <div class="text-center py-12 px-6">
                        <svg class="w-16 h-16 mx-auto text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <p class="text-slate-400 text-lg mb-4">Belum ada task</p>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('projects.tasks.create', $project) }}" class="inline-flex items-center gap-2 px-6 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg font-bold transition-colors">
                                Buat Task Pertama
                            </a>
                        @endif
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-800/50 border-b border-slate-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider w-12">No</th>
                                    <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Task</th>
                                    <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Priority</th>
                                    <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Deadline</th>
                                    <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Anggota</th>
                                    <th class="px-6 py-3 text-center text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700/50">
                                @foreach($tasks as $index => $task)
                                    <tr class="hover:bg-slate-800/30 transition-colors">
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-semibold text-slate-300">{{ ($tasks->currentPage() - 1) * $tasks->perPage() + $index + 1 }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-semibold text-white">{{ $task->title }}</p>
                                            <p class="text-xs text-slate-500 line-clamp-1">{{ Str::limit($task->description, 50) }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($task->priority == 'high')
                                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-[11px] font-bold bg-red-500/10 text-red-400 border border-red-500/20">High 🔥</span>
                                            @elseif($task->priority == 'medium')
                                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-[11px] font-bold bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">Medium ⚠️</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-[11px] font-bold bg-green-500/10 text-green-400 border border-green-500/20">Low ☕</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($task->status == 'completed')
                                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-[11px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">✅ Selesai</span>
                                            @elseif($task->status == 'in_progress')
                                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-[11px] font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20">🚀 Proses</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-[11px] font-bold bg-slate-700/50 text-slate-300 border border-slate-600">⏳ Pending</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm text-slate-400">{{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex -space-x-2">
                                                @foreach($task->users->take(3) as $user)
                                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-white text-[10px] font-bold border border-slate-800" title="{{ $user->name }}">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                @endforeach
                                                @if($task->users->count() > 3)
                                                    <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-white text-[10px] font-bold border border-slate-800 text-slate-400">
                                                        +{{ $task->users->count() - 3 }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('tasks.show', $task) }}" class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-600 hover:bg-indigo-500 text-white text-[11px] font-bold rounded-lg transition-colors">
                                                Buka
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Pagination Links --}}
                    @if($tasks->hasPages())
                        <div class="flex justify-center mt-6 p-4 border-t border-slate-800">
                            {{ $tasks->links('pagination::tailwind') }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
