@if ($user->role === 'admin')
    <x-admin-layout>
        <x-slot name="header">
            Profil akun
        </x-slot>

        <section class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                @include('profile.partials.update-password-form')
            </div>
        </section>
    </x-admin-layout>
@else
    <x-borrower-layout>
        <x-slot name="header">
            Profil akun
        </x-slot>

        <section class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                @include('profile.partials.update-password-form')
            </div>
        </section>
    </x-borrower-layout>
@endif
