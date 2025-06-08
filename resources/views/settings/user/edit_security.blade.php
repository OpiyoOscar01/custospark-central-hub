@extends('layouts.employee')

@section('content')
<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <a href="{{ route('user.profile.show', $user->id) }}" class="hover:text-gray-700">My Profile</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Security Settings</span>
    </nav>

    {{-- Change Password Form --}}
    <form method="POST" action="{{ route('user.security.updatePassword', $user->id) }}"
          class="bg-white border border-gray-200 shadow-sm rounded-2xl overflow-hidden mb-10">
        @csrf
        @method('PUT')

        <header class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-lock-fill text-blue-600"></i> Change Password
            </h2>
        </header>

        <main class="p-6 space-y-6">
            <div class="grid gap-4 sm:grid-cols-2">
                {{-- Current Password --}}
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                    <input id="current_password" name="current_password" type="password"
                           class="mt-1 block w-full rounded-md border border-gray-300 bg-gray-50 p-2 shadow-sm focus:ring-blue-500 focus:border-blue-500 pr-10">
                    @error('current_password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- New Password --}}
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input id="new_password" name="new_password" type="password"
                           class="mt-1 block w-full rounded-md border border-gray-300 bg-gray-50 p-2 shadow-sm focus:ring-blue-500 focus:border-blue-500 pr-10"
                           oninput="checkPasswordStrength(this.value)">
                    <div id="password-strength" class="mt-1 text-xs text-gray-600 italic"></div>
                    @error('new_password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm New Password --}}
                <div class="sm:col-span-2">
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                    <input id="new_password_confirmation" name="new_password_confirmation" type="password"
                           class="mt-1 block w-full rounded-md border border-gray-300 bg-gray-50 p-2 shadow-sm focus:ring-blue-500 focus:border-blue-500 pr-10">
                </div>
            </div>
        </main>

        <footer class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
            <button type="submit"
                    class="inline-flex items-center px-5 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full shadow-sm transition">
                <i class="bi bi-shield-check me-2"></i> Update Password
            </button>
        </footer>
    </form>

    {{-- Two-Factor Authentication (2FA) Toggle Form --}}
    <form method="POST" action="{{ route('user.security.updateTwoFactor', $user->id) }}"
          class="bg-white border border-gray-200 shadow-sm rounded-2xl overflow-hidden mb-10">
        @csrf
        @method('PUT')

        <header class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-shield-lock-fill text-indigo-600"></i> Two-Factor Authentication (2FA)
            </h2>
        </header>

        <main class="p-6 space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-700">Enable Email-Based 2FA</span>

                {{-- Hidden input to submit value even if unchecked --}}
                <input type="hidden" name="two_factor_enabled" value="0">

                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="two_factor_enabled" value="1"
                           class="sr-only peer" onchange="this.form.submit()"
                           {{ old('two_factor_enabled', $user->two_factor_enabled) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-300 rounded-full peer-focus:ring-2 peer-focus:ring-blue-500 peer-checked:bg-blue-600 transition duration-200"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transition duration-200 peer-checked:translate-x-full"></div>
                </label>
            </div>

            @if($user->two_factor_enabled)
                <p class="text-sm text-green-600 flex items-center gap-1">
                    <i class="bi bi-check-circle-fill"></i> 2FA is currently <strong>enabled</strong>. Your account is now more secure.
                </p>
            @else
                <p class="text-sm text-gray-500">2FA is currently <strong>disabled</strong>. Please enable it to make your account more secure.</p>
            @endif
        </main>
    </form>
</div>

{{-- Optional JavaScript for password strength --}}
<script>
    function checkPasswordStrength(password) {
        const strengthEl = document.getElementById('password-strength');
        let strength = 'Weak';
        const regexes = [
            /[a-z]/, // lowercase
            /[A-Z]/, // uppercase
            /[0-9]/, // digit
            /[^A-Za-z0-9]/ // special char
        ];
        let passed = regexes.reduce((acc, regex) => acc + (regex.test(password) ? 1 : 0), 0);

        if(password.length >= 12 && passed >= 3) strength = 'Strong';
        else if(password.length >= 8 && passed >= 2) strength = 'Medium';

        strengthEl.textContent = `Password strength: ${strength}`;
        strengthEl.style.color = strength === 'Strong' ? 'green' : strength === 'Medium' ? 'orange' : 'red';
    }
</script>
@endsection
