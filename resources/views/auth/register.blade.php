<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-6 text-center">
            <h2 class="text-xl font-bold text-white">Buat Akun Baru</h2>
            <p class="text-sm text-slate-400 mt-1">Gabung tim CyberTask sekarang</p>
        </div>

        <div>
            <label for="name" class="block font-medium text-sm text-slate-300">Nama Lengkap</label>
            <input id="name" class="block mt-1 w-full rounded-xl border-slate-700 bg-slate-950/50 text-white placeholder-slate-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 focus:bg-slate-900 transition-all duration-300" 
                   type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Andi Saputra" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="email" class="block font-medium text-sm text-slate-300">Email</label>
            <input id="email" class="block mt-1 w-full rounded-xl border-slate-700 bg-slate-950/50 text-white placeholder-slate-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 focus:bg-slate-900 transition-all duration-300" 
                   type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="email@cybertask.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-slate-300">Password</label>
            <input id="password" class="block mt-1 w-full rounded-xl border-slate-700 bg-slate-950/50 text-white placeholder-slate-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 focus:bg-slate-900 transition-all duration-300" 
                   type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password_confirmation" class="block font-medium text-sm text-slate-300">Konfirmasi Password</label>
            <input id="password_confirmation" class="block mt-1 w-full rounded-xl border-slate-700 bg-slate-950/50 text-white placeholder-slate-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 focus:bg-slate-900 transition-all duration-300" 
                   type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <button type="submit" class="w-full justify-center py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all transform hover:scale-[1.02]">
                {{ __('Daftar Sekarang') }}
            </button>
        </div>

        <div class="mt-6 text-center text-sm text-slate-400">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-medium">Masuk disini</a>
        </div>
    </form>
</x-guest-layout>