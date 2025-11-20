<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white tracking-tight">
            {{ __('Profile Settings') }}
        </h2>
    </x-slot>

    <div class="py-6 space-y-6">
        <div class="p-4 sm:p-8 bg-slate-900 shadow-xl sm:rounded-xl border border-slate-800">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-slate-900 shadow-xl sm:rounded-xl border border-slate-800">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-slate-900 shadow-xl sm:rounded-xl border border-slate-800">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>