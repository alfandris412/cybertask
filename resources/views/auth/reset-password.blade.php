<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <h2 class="text-xl font-bold text-white text-center mb-6">Buat Password Baru</h2>

        <div>
            <label for="email" class="block font-medium text-sm text-slate-300">Email</label>
            <input id="email" class="block mt-1 w-full rounded-xl border-slate-700 bg-slate-950/50 text-white placeholder-slate-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all" 
                   type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-slate-300">Password Baru</label>
            <input id="password" class="block mt-1 w-full rounded-xl border-slate-700 bg-slate-950/50 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all" 
                   type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password_confirmation" class="block font-medium text-sm text-slate-300">Konfirmasi Password</label>
            <input id="password_confirmation" class="block mt-1 w-full rounded-xl border-slate-700 bg-slate-950/50 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all" 
                   type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <button type="submit" class="w-full justify-center py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-xl shadow-lg transition-all transform hover:scale-[1.02]">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>