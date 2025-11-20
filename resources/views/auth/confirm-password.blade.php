<x-guest-layout>
    <div class="mb-6 text-sm text-slate-400">
        {{ __('Ini adalah area aman aplikasi. Harap konfirmasi password Anda sebelum melanjutkan.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div>
            <label for="password" class="block font-medium text-sm text-slate-300">Password</label>
            <input id="password" class="block mt-1 w-full rounded-xl border-slate-700 bg-slate-950/50 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all" 
                   type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="w-full justify-center py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-xl shadow-lg transition-all transform hover:scale-[1.02]">
                {{ __('Konfirmasi') }}
            </button>
        </div>
    </form>
</x-guest-layout>