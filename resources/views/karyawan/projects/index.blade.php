<x-app-layout>
    <x-slot name="header">
        {{ __('Project Saya') }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-900 border border-slate-800 shadow-2xl rounded-2xl overflow-hidden">
                @if($projects->isEmpty())
                    <div class="p-10 text-center text-slate-400 text-sm">
                        Belum ada project yang melibatkan kamu.
                    </div>
                @else
                    <div class="overflow-x-auto w-full">
                        <table class="w-full align-middle">
                            <thead>
                                <tr class="bg-slate-950/50 border-b border-slate-800">
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Project</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Periode</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Anggota</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800">
                                @foreach($projects as $project)
                                    <tr class="hover:bg-slate-800/40 transition-colors">
                                        <td class="px-6 py-3 text-sm text-white">
                                            <div class="font-semibold">{{ $project->name }}</div>
                                            <div class="text-xs text-slate-400 line-clamp-1">{{ $project->description }}</div>
                                        </td>
                                        <td class="px-6 py-3 text-sm text-slate-300">
                                            {{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }}
                                            -
                                            {{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-3 text-sm text-slate-300">
                                            {{ $project->members->count() }} orang
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
