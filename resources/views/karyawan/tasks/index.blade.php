<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-white tracking-tight">
                {{ __('Tugas Saya') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-900 border border-slate-800 shadow-2xl rounded-2xl overflow-hidden">
                @if($tasks->isEmpty())
                    <div class="p-10 text-center text-slate-400 text-sm">
                        Belum ada tugas yang ditugaskan ke kamu.
                    </div>
                @else
                    <div class="overflow-x-auto w-full">
                        <table class="w-full align-middle">
                            <thead>
                                <tr class="bg-slate-950/50 border-b border-slate-800">
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Project</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Deadline</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-400 uppercase tracking-wider pr-8">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800">
                                @foreach($tasks as $task)
                                    <tr class="hover:bg-slate-800/40 transition-colors">
                                        <td class="px-6 py-3 text-sm text-white">
                                            {{ $task->title }}
                                        </td>
                                        <td class="px-6 py-3 text-sm text-slate-300">
                                            {{ $task->project->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-3 text-sm text-slate-300">
                                            {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-3 text-sm">
                                            @if($task->status == 'completed')
                                                <span class="px-2 py-0.5 rounded-full text-xs bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Selesai</span>
                                            @elseif($task->status == 'in_progress')
                                                <span class="px-2 py-0.5 rounded-full text-xs bg-blue-500/10 text-blue-400 border border-blue-500/20">Proses</span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-full text-xs bg-slate-700 text-slate-300 border border-slate-600">Pending</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-3 text-right pr-8">
                                            <a href="{{ route('tasks.show', $task) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white">
                                                Buka Ruang Kerja
                                            </a>
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
