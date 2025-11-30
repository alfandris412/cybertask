<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-white tracking-tight">
                {{ __('Edit Tugas') }}
            </h2>
            <a href="{{ route('projects.show', $task->project) }}" class="text-slate-400 hover:text-white transition-colors text-sm">
                &larr; Kembali ke Project
            </a>
        </div>
    </x-slot>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #1e293b; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #475569; border-radius: 3px; }
    </style>

    <div class="py-8">
        <div class="max-w-5xl mx-auto">
            <div class="bg-slate-900 border border-slate-800 shadow-2xl rounded-2xl overflow-hidden relative">
                
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="p-8 text-slate-300 relative z-10" 
                     x-data="{
                        projectId: '{{ $task->project_id }}',
                        projectMembers: [],
                        selectedUsers: [],
                        isLoading: false,
                        assignMode: 'manual',

                        async fetchMembers() {
                            if (!this.projectId) return;
                            
                            this.isLoading = true;
                            this.projectMembers = [];
                            this.selectedUsers = [];

                            try {
                                let response = await fetch(`/projects/${this.projectId}/members`);
                                this.projectMembers = await response.json();
                                
                                // Pre-select current task members
                                const currentMemberIds = {!! Js::from($task->users->pluck('id')->toArray()) !!};
                                this.selectedUsers = currentMemberIds;
                            } catch (error) {
                                console.error('Error:', error);
                            } finally {
                                this.isLoading = false;
                            }
                        },

                        get uniqueRoles() {
                            const roles = this.projectMembers.map(m => m.project_role);
                            return [...new Set(roles)];
                        },

                        countMemberByRole(roleName) {
                            return this.projectMembers.filter(u => u.project_role === roleName).length;
                        },

                        toggleRoleGroup(roleName) {
                            const idsInRole = this.projectMembers
                                .filter(u => u.project_role === roleName)
                                .map(u => u.id);

                            const allSelected = idsInRole.every(id => this.selectedUsers.includes(id));

                            if (allSelected) {
                                this.selectedUsers = this.selectedUsers.filter(id => !idsInRole.includes(id));
                            } else {
                                this.selectedUsers = [...new Set([...this.selectedUsers, ...idsInRole])];
                            }
                        },
                        
                        isRoleSelected(roleName) {
                             const idsInRole = this.projectMembers
                                .filter(u => u.project_role === roleName)
                                .map(u => u.id);
                            return idsInRole.length > 0 && idsInRole.every(id => this.selectedUsers.includes(id));
                        },

                        init() {
                            if (this.projectId) {
                                this.fetchMembers();
                            }
                        }
                     }">
                    
                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-white mb-2">Judul Tugas <span class="text-red-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $task->title) }}" class="w-full rounded-2xl border-slate-700 bg-slate-950/50 text-white placeholder-slate-500 shadow-inner focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 focus:bg-slate-900 transition-all duration-300 p-3" placeholder="Contoh: Fix Bug Login" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-white mb-2">Project <span class="text-red-500">*</span></label>
                            <input type="text" disabled class="w-full rounded-2xl border-slate-700 bg-slate-950/50 text-slate-500 shadow-inner p-3 cursor-not-allowed" value="{{ $task->project->name }}">
                            <p class="text-xs text-slate-500 mt-1">Project tidak dapat diubah setelah pembuatan tugas.</p>
                        </div>

                        <div class="mb-8 bg-slate-950/30 border border-slate-800 p-6 rounded-2xl transition-all">
                            
                            <div class="flex justify-between items-center mb-6">
                                <label class="block text-sm font-bold text-indigo-400 uppercase tracking-wider">
                                    Target Penugasan <span class="text-xs bg-indigo-500/20 text-white px-2 py-0.5 rounded-full ml-2" x-text="selectedUsers.length + ' Orang'"></span>
                                </label>

                                <div class="bg-slate-900 p-1 rounded-lg border border-slate-700 flex">
                                    <button type="button" @click="assignMode = 'manual'" 
                                            class="px-4 py-1.5 rounded-md text-xs font-bold transition-all"
                                            :class="assignMode === 'manual' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:text-white'">
                                        Individual
                                    </button>
                                    <button type="button" @click="assignMode = 'role'" 
                                            class="px-4 py-1.5 rounded-md text-xs font-bold transition-all"
                                            :class="assignMode === 'role' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:text-white'">
                                        Per Divisi
                                    </button>
                                </div>
                            </div>

                            <div x-show="isLoading" class="py-8 text-center">
                                <svg class="animate-spin h-8 w-8 text-indigo-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <p class="text-xs text-slate-500 mt-2">Sinkronisasi Data Tim...</p>
                            </div>

                            <div x-show="!isLoading && assignMode === 'manual'">
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 max-h-64 overflow-y-auto custom-scrollbar pr-2">
                                    <template x-for="member in projectMembers" :key="member.id">
                                        <label class="flex items-center p-3 rounded-xl border border-slate-700 bg-slate-900 hover:bg-slate-800 cursor-pointer transition-all group"
                                               :class="selectedUsers.includes(member.id) ? 'border-indigo-500 bg-indigo-900/10' : ''">
                                            
                                            <input type="checkbox" name="user_ids[]" :value="member.id" x-model="selectedUsers" class="w-5 h-5 rounded border-slate-600 bg-slate-950 text-indigo-600 focus:ring-indigo-500">
                                            
                                            <div class="ml-3">
                                                <p class="text-sm font-bold text-white group-hover:text-indigo-300 transition-colors" x-text="member.name"></p>
                                                <p class="text-[10px] font-mono text-indigo-400 bg-indigo-500/10 px-1.5 py-0.5 rounded w-fit mt-0.5 border border-indigo-500/20" x-text="member.project_role"></p>
                                            </div>
                                        </label>
                                    </template>
                                </div>
                                <div x-show="projectMembers.length === 0" class="text-center text-slate-500 text-sm py-4">Tidak ada anggota di project ini.</div>
                            </div>

                            <div x-show="!isLoading && assignMode === 'role'">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <template x-for="role in uniqueRoles" :key="role">
                                        <div @click="toggleRoleGroup(role)" 
                                             class="p-4 rounded-xl border cursor-pointer transition-all flex items-center justify-between group"
                                             :class="isRoleSelected(role) ? 'bg-indigo-600 border-indigo-500 shadow-lg' : 'bg-slate-900 border-slate-700 hover:border-slate-500'">
                                            
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold"
                                                     :class="isRoleSelected(role) ? 'bg-white/20' : 'bg-slate-800'">
                                                    <span x-text="role.substring(0, 1)"></span>
                                                </div>
                                                <div>
                                                    <p class="font-bold text-sm" :class="isRoleSelected(role) ? 'text-white' : 'text-slate-200'" x-text="role"></p>
                                                    <p class="text-xs" :class="isRoleSelected(role) ? 'text-indigo-200' : 'text-slate-500'" x-text="countMemberByRole(role) + ' Anggota'"></p>
                                                </div>
                                            </div>

                                            <div x-show="isRoleSelected(role)">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <p class="text-xs text-slate-500 mt-4 italic text-center">Klik kartu divisi untuk memilih semua anggotanya.</p>
                            </div>

                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-white mb-2">Detail Instruksi <span class="text-red-500">*</span></label>
                            <textarea name="description" rows="4" class="w-full rounded-2xl border-slate-700 bg-slate-950/50 text-white placeholder-slate-500 shadow-inner focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 focus:bg-slate-900 transition-all duration-300 p-3" placeholder="Jelaskan apa yang harus dikerjakan..." required>{{ old('description', $task->description) }}</textarea>
                            @error('description')<span class="text-red-500 text-xs mt-1 block font-bold">⚠️ Deskripsi wajib diisi!</span>@enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label class="block text-sm font-bold text-white mb-2">Prioritas <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="priority" class="w-full rounded-2xl border-slate-700 bg-slate-950/50 text-white shadow-inner focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 focus:bg-slate-900 transition-all duration-300 p-3 appearance-none cursor-pointer" required>
                                        <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>🟢 Low (Santai)</option>
                                        <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>⚠️ Medium (Standar)</option>
                                        <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>🔥 High (Mendesak)</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-white mb-2">Deadline <span class="text-red-500">*</span></label>
                                <input type="date" name="due_date" value="{{ old('due_date', $task->due_date) }}" class="w-full rounded-2xl border-slate-700 bg-slate-950/50 text-white shadow-inner focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 focus:bg-slate-900 transition-all duration-300 p-3" required>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="flex-1 py-3.5 px-4 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all transform hover:scale-[1.01] focus:ring-4 focus:ring-indigo-500/30">
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('tasks.show', $task) }}" class="py-3.5 px-4 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl shadow-lg border border-slate-700 transition-all">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
