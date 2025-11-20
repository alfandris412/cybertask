<x-app-layout>
    <x-slot name="header">
        {{ __('Manajemen Project') }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Top Bar: Tombol Tambah -->
            <div class="flex justify-end mb-6">
                <a href="{{ route('projects.create') }}" class="group inline-flex items-center px-5 py-3 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all transform hover:scale-105">
                    <div class="mr-2 p-1 rounded-full bg-white/20 group-hover:bg-white/30 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    Project Baru
                </a>
            </div>

            <!-- Alert Sukses -->
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                     class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 shadow-lg flex items-center gap-3 animate-fade-in-up">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Tabel Data -->
            <div class="bg-slate-900 border border-slate-800 shadow-2xl rounded-2xl overflow-hidden">
                
                @if($projects->isEmpty())
                    <!-- Tampilan Kosong -->
                    <div class="p-12 text-center flex flex-col items-center justify-center">
                        <div class="w-24 h-24 bg-slate-800/50 rounded-full flex items-center justify-center mb-4 border-2 border-dashed border-slate-700">
                            <svg class="w-10 h-10 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h3 class="text-white text-lg font-bold mb-2">Belum ada Project</h3>
                        <p class="text-slate-500 max-w-sm">Data project akan muncul di sini setelah Anda membuatnya.</p>
                    </div>
                @else
                    <div class="overflow-x-auto w-full">
                        <!-- TABEL FULL WIDTH -->
                        <table class="w-full align-middle">
                            <thead>
                                <tr class="bg-slate-950/50 border-b border-slate-800">
                                    <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider w-[35%]">Project Info</th>
                                    <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider w-[20%]">Anggota Tim</th>
                                    <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider w-[25%]">Timeline</th>
                                    <th class="px-6 py-5 text-right text-xs font-bold text-slate-400 uppercase tracking-wider w-[20%] pr-8">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800">
                                @foreach($projects as $project)
                                <tr class="hover:bg-slate-800/50 transition-colors group">
                                    
                                    <!-- Info Project -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="flex-shrink-0 h-12 w-12 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 border border-indigo-500/20 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                                            </div>
                                            <div>
                                                <a href="{{ route('projects.show', $project) }}" class="text-base font-bold text-white hover:text-indigo-400 transition-colors line-clamp-1">
                                                    {{ $project->name }}
                                                </a>
                                                <div class="text-sm text-slate-500 mt-1 line-clamp-1">{{ Str::limit($project->description, 40) }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Anggota Tim (Avatar) -->
                                    <td class="px-6 py-4">
                                        <div class="flex -space-x-3 hover:space-x-1 transition-all duration-300">
                                            @forelse($project->members->take(3) as $member)
                                                <div class="relative h-10 w-10 rounded-full ring-2 ring-slate-900 bg-indigo-600 flex items-center justify-center text-white text-xs font-bold overflow-hidden hover:z-10 hover:scale-110 transition-transform cursor-help" title="{{ $member->name }}">
                                                    @if($member->avatar)
                                                        <img src="{{ asset('storage/' . $member->avatar) }}" class="h-full w-full object-cover" alt="{{ $member->name }}">
                                                    @else
                                                        {{ substr($member->name, 0, 1) }}
                                                    @endif
                                                </div>
                                            @empty
                                                <span class="text-sm text-slate-500 italic px-3 py-1 rounded-full bg-slate-800 border border-slate-700">Belum ada tim</span>
                                            @endforelse
                                            
                                            @if($project->members->count() > 3)
                                                <div class="relative h-10 w-10 rounded-full ring-2 ring-slate-900 bg-slate-700 flex items-center justify-center text-white text-xs font-bold">
                                                    +{{ $project->members->count() - 3 }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Timeline -->
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-1">
                                            <div class="text-xs text-slate-400">Mulai: <span class="text-slate-200">{{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }}</span></div>
                                            <div class="text-xs text-slate-400">Target: <span class="text-indigo-400 font-bold">{{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}</span></div>
                                        </div>
                                    </td>

                                    <!-- Aksi -->
                                    <td class="px-6 py-4 text-right pr-8">
                                        <div class="flex justify-end gap-2">
                                            
                                            <!-- Tombol Show (Mata) -->
                                            <a href="{{ route('projects.show', $project) }}" class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-blue-600 transition-all border border-transparent hover:border-blue-500/30" title="Lihat Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>

                                            <!-- Tombol Edit -->
                                            <a href="{{ route('projects.edit', $project) }}" class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-indigo-600 transition-all border border-transparent hover:border-indigo-500/30" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>
                                            
                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Hapus project ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-red-600 transition-all border border-transparent hover:border-red-500/30" title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.86 13H5.86L5 7h14zm-4 0V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2h8z"></path></svg>
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