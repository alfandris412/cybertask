<x-guest-layout>
    <div class="mb-6 text-sm text-slate-400 leading-relaxed">
        {{ __('Lupa password Anda? Tidak masalah. Cukup beri tahu kami alamat email Anda dan kami akan mengirimkan tautan pengaturan ulang password.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <label for="email" class="block font-medium text-sm text-slate-300">Email</label>
            <input id="email" class="block mt-1 w-full rounded-xl border-slate-700 bg-slate-950/50 text-white placeholder-slate-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 focus:bg-slate-900 transition-all duration-300" 
                   type="email" name="email" :value="old('email')" required autofocus placeholder="email@cybertask.com"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <button type="submit" class="w-full justify-center py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all transform hover:scale-[1.02]">
                {{ __('Kirim Link Reset') }}
            </button>
        </div>
        
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-indigo-400 hover:text-indigo-300">Kembali ke Login</a>
        </div>
    </form>
</x-guest-layout>