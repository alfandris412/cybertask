<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-6 text-center">
            <h2 class="text-xl font-bold text-white">Selamat Datang</h2>
            <p class="text-sm text-slate-400 mt-1">Silakan masuk untuk melanjutkan</p>
        </div>

        <div>
            <label for="email" class="block font-medium text-sm text-slate-300">Email</label>
            <input id="email" class="block mt-1 w-full rounded-xl border-slate-700 bg-slate-950/50 text-white placeholder-slate-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 focus:bg-slate-900 transition-all duration-300" 
                   type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="email@cybertask.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-slate-300">Password</label>
            <input id="password" class="block mt-1 w-full rounded-xl border-slate-700 bg-slate-950/50 text-white placeholder-slate-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 focus:bg-slate-900 transition-all duration-300" 
                   type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4 flex justify-between items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-700 bg-slate-900 text-indigo-500 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-slate-400 hover:text-slate-300">{{ __('Ingat Saya') }}</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-400 hover:text-indigo-300 font-medium transition-colors" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div class="flex items-center justify-end mt-6">
            <button type="submit" class="w-full justify-center py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all transform hover:scale-[1.02]">
                {{ __('Masuk Dashboard') }}
            </button>
        </div>
        
        <div class="mt-6 text-center text-sm text-slate-400">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 font-medium">Daftar disini</a>
        </div>
    </form>
</x-guest-layout>