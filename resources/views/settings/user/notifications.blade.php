@extends('layouts.employee')

@section('content')
<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

    {{-- Breadcrumb --}}
 <nav class="mb-6 flex items-center space-x-2 text-sm text-gray-500">
    <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
    <i class="bi bi-chevron-right text-xs"></i>
    <a href="{{ route('user.profile.show', $user->id) }}" class="hover:text-gray-700">My Profile</a>
    <i class="bi bi-chevron-right text-xs"></i>
    <span class="text-gray-900">Notification Preferences</span>
</nav>
    {{-- Notification Preferences Form --}}
    <form method="POST" action="{{ route('user.notifications.updatePreferences', $user->id) }}"
          class="bg-white border border-gray-200 shadow-sm rounded-2xl overflow-hidden mb-10">
        @csrf
        @method('PUT')

        <header class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-bell-fill text-blue-500"></i> Notification Preferences
            </h2>
        </header>

        <main class="p-6 space-y-6">
            @php
                $preferences = old('notification_preferences', $user->notification_preferences ?? []);
            @endphp

            {{-- Email Alerts --}}
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-700">Receive Email Notifications</span>
                <input type="hidden" name="notification_preferences[email]" value="0">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="notification_preferences[email]" value="1"
                           class="sr-only peer" {{ $preferences['email'] ?? false ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-300 rounded-full peer-checked:bg-blue-600 transition"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transition peer-checked:translate-x-full"></div>
                </label>
            </div>

            {{-- In-App Notifications --}}
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-700">Receive In-App Notifications</span>
                <input type="hidden" name="notification_preferences[in_app]" value="0">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="notification_preferences[in_app]" value="1"
                           class="sr-only peer" {{ $preferences['in_app'] ?? true ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-300 rounded-full peer-checked:bg-blue-600 transition"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transition peer-checked:translate-x-full"></div>
                </label>
            </div>

            {{-- System Announcements --}}
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-700">Receive System Announcements</span>
                <input type="hidden" name="notification_preferences[system]" value="0">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="notification_preferences[system]" value="1"
                           class="sr-only peer" {{ $preferences['system'] ?? true ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-300 rounded-full peer-checked:bg-blue-600 transition"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transition peer-checked:translate-x-full"></div>
                </label>
            </div>
        </main>

        <footer class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
            <button type="submit"
                    class="inline-flex items-center px-5 py-2 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-full shadow-sm transition">
                <i class="bi bi-save me-2"></i> Save Preferences
            </button>
        </footer>
    </form>

   {{-- Newsletter and Marketing Opt-In Forms --}}
<div class="space-y-6">

    {{-- Newsletter Opt-In Form --}}
    <form method="POST" action="{{ route('user.preferences.updateNewsletter', $user->id) }}">
        @csrf
        @method('PUT')

        <label class="inline-flex items-center cursor-pointer relative">
            {{-- Hidden input to submit 0 if unchecked --}}
            <input type="hidden" name="newsletter_opt_in" value="0">
            <input type="checkbox" name="newsletter_opt_in" value="1" class="sr-only peer"
                   onchange="this.form.submit()"
                   {{ old('newsletter_opt_in', $user->newsletter_opt_in) ? 'checked' : '' }}>

            {{-- Toggle background --}}
            <div class="w-11 h-6 bg-gray-300 rounded-full peer-checked:bg-blue-600 transition duration-200"></div>
            {{-- Toggle knob --}}
            <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transition duration-200 peer-checked:translate-x-full"></div>

            <span class="ml-3 text-gray-700 relative">Subscribe to Newsletter</span>
        </label>
    </form>

    {{-- Marketing Opt-In Form --}}
    <form method="POST" action="{{ route('user.preferences.updateMarketing', $user->id) }}">
        @csrf
        @method('PUT')

        <label class="inline-flex items-center cursor-pointer relative">
            {{-- Hidden input to submit 0 if unchecked --}}
            <input type="hidden" name="marketing_opt_in" value="0">
            <input type="checkbox" name="marketing_opt_in" value="1" class="sr-only peer"
                   onchange="this.form.submit()"
                   {{ old('marketing_opt_in', $user->marketing_opt_in) ? 'checked' : '' }}>

            {{-- Toggle background --}}
            <div class="w-11 h-6 bg-gray-300 rounded-full peer-checked:bg-blue-600 transition duration-200"></div>
            {{-- Toggle knob --}}
            <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transition duration-200 peer-checked:translate-x-full"></div>
        </label>

        <span class="ml-3 text-gray-700">Opt-in to Marketing</span>
    </form>

</div>

    

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
