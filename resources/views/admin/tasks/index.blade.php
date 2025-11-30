<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-white tracking-tight">
                {{ __('Daftar Tugas') }}
            </h2>
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Tugas Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                     class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 shadow-lg flex items-center gap-3 animate-fade-in-up">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-slate-900 border border-slate-800 shadow-2xl rounded-2xl overflow-hidden">
                
                @if($tasks->isEmpty())
                    <div class="p-12 text-center flex flex-col items-center justify-center">
                        <div class="w-24 h-24 bg-slate-800/50 rounded-full flex items-center justify-center mb-4 border-2 border-dashed border-slate-700">
                            <svg class="w-10 h-10 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <h3 class="text-white text-lg font-bold mb-2">Belum ada Tugas</h3>
                        <p class="text-slate-500 max-w-sm">Silakan buat tugas pertama Anda dan delegasikan ke tim.</p>
                    </div>
                @else
                    <div class="overflow-x-auto w-full">
                        <table class="w-full align-middle">
                            <thead>
                                <tr class="bg-slate-950/50 border-b border-slate-800">
                                    <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider w-[30%]">Judul Tugas</th>
                                    <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider w-[20%]">Project & Tim</th>
                                    <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider w-[15%]">Prioritas</th>
                                    <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider w-[15%]">Status</th>
                                    <th class="px-6 py-5 text-right text-xs font-bold text-slate-400 uppercase tracking-wider w-[20%] pr-8">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800">
                                @foreach($tasks as $task)
                                <tr class="hover:bg-slate-800/50 transition-colors group">
                                    
                                    <td class="px-6 py-4">
                                        <div class="flex items-start gap-3">
                                            <div class="mt-1.5 flex-shrink-0 w-2.5 h-2.5 rounded-full {{ $task->priority == 'high' ? 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.6)]' : ($task->priority == 'medium' ? 'bg-yellow-500' : 'bg-green-500') }}"></div>
                                            <div>
                                                <a href="{{ route('tasks.show', $task) }}" class="text-sm font-bold text-white hover:text-indigo-400 transition-colors line-clamp-2">
                                                    {{ $task->title }}
                                                </a>
                                                <div class="text-xs text-slate-500 mt-1">Deadline: <span class="text-slate-300">{{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</span></div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-2">
                                            <div class="text-[10px] font-bold text-indigo-300 bg-indigo-500/10 border border-indigo-500/20 px-2 py-0.5 rounded w-fit tracking-wide uppercase">
                                                {{ Str::limit($task->project->name, 15) }}
                                            </div>
                                            
                                            <div class="flex -space-x-3 overflow-hidden py-1 pl-1">
                                                @foreach($task->users->take(4) as $assignee)
                                                    <div class="relative w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-[10px] text-white font-bold ring-2 ring-slate-900 shadow-lg cursor-help group/tooltip hover:z-10 hover:scale-110 transition-transform">
                                                        @if($assignee->avatar)
                                                            <img src="{{ asset('storage/' . $assignee->avatar) }}" class="w-full h-full rounded-full object-cover">
                                                        @else
                                                            {{ strtoupper(substr($assignee->name, 0, 2)) }}
                                                        @endif
                                                        
                                                        <div class="absolute bottom-full mb-2 hidden group-hover/tooltip:block bg-black text-white text-[10px] px-2 py-1 rounded whitespace-nowrap z-20 shadow-xl">
                                                            {{ $assignee->name }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                                
                                                @if($task->users->count() > 4)
                                                    <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-[10px] text-slate-300 ring-2 ring-slate-900 font-bold">
                                                        +{{ $task->users->count() - 4 }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($task->priority == 'high')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/10 text-red-400 border border-red-500/20">High 🔥</span>
                                        @elseif($task->priority == 'medium')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">Medium ⚠️</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20">Low ☕</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($task->status == 'completed')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Selesai
                                            </span>
                                        @elseif($task->status == 'in_progress')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span> Proses
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-700 text-slate-300 border border-slate-600">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Pending
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-right pr-8">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('tasks.show', $task) }}" class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-blue-600 transition-all border border-transparent hover:border-blue-500/30" title="Lihat Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <a href="{{ route('tasks.edit', $task) }}" class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-indigo-600 transition-all border border-transparent hover:border-indigo-500/30" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>
                                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Hapus tugas ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-red-600 transition-all border border-transparent hover:border-red-500/30" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.86 13H5.86L5 7h14zm-4 0V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2h8z"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>