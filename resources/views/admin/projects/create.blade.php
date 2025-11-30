<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-white tracking-tight">
                {{ __('Tambah Project Baru') }}
            </h2>
            <a href="{{ route('projects.index') }}" class="text-slate-400 hover:text-white transition-colors text-sm">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <style>
        @keyframes float-avatar { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-8px); } }
        .animate-float-avatar { animation: float-avatar 3s ease-in-out infinite; }
        /* Custom Scrollbar untuk Modal */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #1e293b; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #475569; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #64748b; }
    </style>

    <div class="py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-slate-900 border border-slate-800 shadow-2xl rounded-2xl overflow-hidden relative">
                <!-- Background Glow -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="p-8 text-slate-300 relative z-10">
                    
                    <form action="{{ route('projects.store') }}" method="POST" x-data="projectForm()">
                        @csrf 
                        
                        <!-- 1. Nama Project -->
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-white mb-2">Nama Project <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" 
                                   class="w-full rounded-2xl border-slate-700 bg-slate-950/50 text-white placeholder-slate-500 shadow-inner focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 focus:bg-slate-900 transition-all duration-300 p-3" 
                                   placeholder="Contoh: Website Company Profile" required autofocus>
                            @error('name')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                        </div>

                        <!-- 2. Deskripsi -->
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-white mb-2">Deskripsi Singkat</label>
                            <textarea name="description" rows="3" 
                                      class="w-full rounded-2xl border-slate-700 bg-slate-950/50 text-white placeholder-slate-500 shadow-inner focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 focus:bg-slate-900 transition-all duration-300 p-3" 
                                      placeholder="Jelaskan detail project ini...">{{ old('description') }}</textarea>
                        </div>

                        <!-- 3. Link Repository -->
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-white mb-2">Link Repository GitHub</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                </div>
                                <input type="url" name="repository_link" 
                                       class="w-full pl-10 rounded-2xl border-slate-700 bg-slate-950/50 text-white placeholder-slate-500 shadow-inner focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 focus:bg-slate-900 transition-all duration-300 p-3" 
                                       placeholder="https://github.com/username/project-repo">
                            </div>
                        </div>

                        <!-- 4. Tanggal (FIX: Styling disamakan) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label class="block text-sm font-bold text-white mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                                <input type="date" name="start_date" 
                                       class="w-full rounded-2xl border-slate-700 bg-slate-950/50 text-white shadow-inner focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 focus:bg-slate-900 transition-all duration-300 p-3" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-white mb-2">Target Selesai <span class="text-red-500">*</span></label>
                                <input type="date" name="end_date" 
                                       class="w-full rounded-2xl border-slate-700 bg-slate-950/50 text-white shadow-inner focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 focus:bg-slate-900 transition-all duration-300 p-3" required>
                            </div>
                        </div>

                        <!-- 5. Anggota Tim (FIX: Tinggi Kotak Ditambah) -->
                        <div class="mb-8" x-data="{ 
                            openModal: false, 
                            search: '', 
                            selectedIds: [],
                            selectedRoles: {},
                            allKaryawan: {{ $karyawan->map(fn($u) => ['id' => $u->id, 'name' => $u->name, 'email' => $u->email, 'initial' => substr($u->name, 0, 2)]) }},
                            
                            get selectedUsers() {
                                return this.allKaryawan.filter(user => this.selectedIds.map(String).includes(String(user.id)));
                            },
                            toggleSelection(id) {
                                if (this.selectedIds.includes(id)) {
                                    this.selectedIds = this.selectedIds.filter(i => i !== id);
                                    delete this.selectedRoles[id];
                                } else {
                                    this.selectedIds.push(id);
                                    this.selectedRoles[id] = '';
                                }
                            }
                        }">
                            <label class="block text-sm font-bold text-indigo-400 mb-4 uppercase tracking-wider flex items-center justify-between">
                                <span>Atur Tim & Posisi</span>
                                <span class="text-xs bg-indigo-500/20 text-indigo-300 px-2 py-1 rounded-full" x-text="selectedIds.length + ' Orang Dipilih'"></span>
                            </label>

                            <!-- Trigger Area (Tinggi 150px biar lega) -->
                            <div class="relative min-h-[150px] p-6 rounded-2xl bg-slate-950/30 border border-slate-800 flex flex-col items-center justify-center text-center border-dashed hover:border-indigo-500/50 transition-all cursor-pointer group overflow-hidden" @click="openModal = true">
                                
                                <!-- KOSONG -->
                                <div x-show="selectedIds.length === 0" class="flex flex-col items-center animate-fade-in-up">
                                    <div class="w-14 h-14 rounded-full bg-slate-900 flex items-center justify-center group-hover:bg-indigo-600 text-slate-400 group-hover:text-white transition-colors mb-3">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                    </div>
                                    <p class="text-sm font-bold text-white group-hover:text-indigo-400">Klik untuk Kelola Tim</p>
                                    <p class="text-xs text-slate-500 mt-1">Cari dan tambahkan karyawan ke project ini</p>
                                </div>

                                <!-- TERISI (Avatar Melayang) -->
                                <div x-show="selectedIds.length > 0" class="w-full flex flex-wrap items-center justify-center gap-4 z-10" style="display: none;">
                                    <template x-for="(user, index) in selectedUsers" :key="user.id">
                                        <div class="flex flex-col items-center animate-float-avatar" :style="`animation-delay: ${index * 0.2}s`">
                                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-lg border-2 border-slate-800">
                                                <span x-text="user.initial"></span>
                                            </div>
                                            <span class="text-[10px] text-slate-300 mt-2 bg-slate-900/80 px-2 py-0.5 rounded-full" x-text="user.name.split(' ')[0]"></span>
                                        </div>
                                    </template>
                                    <!-- Ikon Tambah Kecil -->
                                    <div class="w-10 h-10 rounded-full border-2 border-dashed border-slate-600 flex items-center justify-center text-slate-500 hover:text-white transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL POPUP -->
                            <div x-show="openModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6">
                                <div class="absolute inset-0 bg-slate-950/90 backdrop-blur-sm" @click="openModal = false"></div>

                                <div class="relative bg-slate-900 border border-slate-700 rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all flex flex-col max-h-[80vh]">
                                    
                                    <div class="px-6 py-4 border-b border-slate-700 flex justify-between items-center bg-slate-800/50">
                                        <h3 class="text-lg font-bold text-white">Plotting Tim</h3>
                                        <button type="button" @click="openModal = false" class="text-slate-400 hover:text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                    </div>

                                    <div class="p-4 bg-slate-900 border-b border-slate-700">
                                        <div class="relative">
                                            <svg class="absolute left-3 top-3 w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                            <input type="text" x-model="search" class="w-full pl-10 pr-4 py-2.5 rounded-xl border-slate-700 bg-slate-950 text-white placeholder-slate-500 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Cari nama karyawan...">
                                        </div>
                                    </div>

                                    <div class="overflow-y-auto p-4 space-y-3 custom-scrollbar flex-1">
                                        @foreach($karyawan as $k)
                                        <div class="flex items-center gap-4 p-3 rounded-xl border border-slate-800 hover:border-indigo-500/30 transition-colors bg-slate-950/50 group"
                                             x-show="search === '' || '{{ strtolower($k->name) }}'.includes(search.toLowerCase())">
                                            
                                            <div class="flex items-center h-full">
                                                <input type="checkbox" :checked="selectedIds.includes('{{ $k->id }}')"
                                                       @change="toggleSelection('{{ $k->id }}')"
                                                       class="w-5 h-5 rounded border-slate-600 bg-slate-900 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                                            </div>

                                            <div class="flex-1">
                                                <p class="text-sm font-bold text-white group-hover:text-indigo-300 transition-colors">{{ $k->name }}</p>
                                                <p class="text-xs text-slate-500">{{ $k->email }}</p>
                                            </div>

                                            <div class="w-1/2" x-show="selectedIds.includes('{{ $k->id }}')" x-transition>
                                                <input type="text" x-model="selectedRoles['{{ $k->id }}']"
                                                       class="w-full text-xs rounded-lg border-slate-700 bg-slate-900 text-indigo-300 placeholder-slate-600 focus:border-indigo-500 focus:ring-indigo-500 p-2" 
                                                       placeholder="Posisi? (ex: Frontend)">
                                            </div>
                                        </div>
                                        @endforeach
                                        @if($karyawan->isEmpty())
                                            <div class="text-center py-8 text-slate-500">Belum ada data karyawan.</div>
                                        @endif
                                    </div>

                                    <div class="p-4 border-t border-slate-700 bg-slate-800/50 text-right">
                                        <button type="button" @click="openModal = false" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-lg shadow-lg transition-all">Selesai Plotting</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden inputs untuk submit members -->
                            <template x-for="memberId in selectedIds" :key="memberId">
                                <input type="hidden" name="members[]" :value="memberId">
                                <input type="hidden" :name="`roles[${memberId}]`" :value="selectedRoles[memberId] || 'Member'">
                            </template>
                        </div>

                        <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all transform hover:scale-[1.01] focus:ring-4 focus:ring-indigo-500/30 disabled:opacity-75 disabled:scale-100 disabled:cursor-not-allowed" :disabled="isSubmitting">
                            <span x-show="!isSubmitting" class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Simpan Project
                            </span>
                            <span x-show="isSubmitting" class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Menyimpan...
                            </span>
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function projectForm() {
            return {
                isSubmitting: false,

                init() {
                    this.$watch('$el.form', (form) => {
                        if (form) {
                            form.addEventListener('submit', (e) => {
                                this.isSubmitting = true;
                            });
                        }
                    });
                }
            };
        }
    </script>
</x-app-layout>