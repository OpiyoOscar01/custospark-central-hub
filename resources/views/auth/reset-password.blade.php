@extends('auth.auth-main')

@section('title', 'Password Reset')

@section('content')
<div class="w-full max-w-sm bg-black/50 backdrop-blur-lg border border-white/20 rounded-xl shadow-xl px-6 py-8 space-y-5">

    <!-- Logo -->
    <div class="text-center">
        <a href="/" class="inline-flex items-center space-x-2">
            <img src="{{ asset('images/v8.png') }}" alt="Custospark Logo"
                 class="w-14 h-14 rounded-full shadow border border-white/30">
            <span class="text-xl font-bold text-white">
                <span class="text-blue-400">Custospark</span>
            </span>
        </a>
    </div>

    <!-- Headings -->
    <div class="text-center space-y-0.5">
        <h1 class="text-xl font-semibold text-blue-300">Reset Your Password</h1>
        <p class="text-xs text-gray-300">Enter your new password below.</p>
    </div>

    <!-- Reset Password Form -->
    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <div class="relative bg-black/30 border border-gray-600 rounded-lg px-3 py-2">
            <label for="email" class="block text-xs font-medium text-gray-200 mb-0.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                   class="w-full bg-transparent text-white text-sm outline-none placeholder-gray-400" placeholder="you@example.com">
            <i class="fas fa-envelope absolute right-3 top-1/2 transform -translate-y-1/2 text-xs text-gray-400"></i>
            @error('email')
                <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
            @enderror
        </div>

        <!-- New Password -->
        <div class="relative bg-black/30 border border-gray-600 rounded-lg px-3 py-2">
            <label for="password" class="block text-xs font-medium text-gray-200 mb-0.5">New Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full bg-transparent text-white text-sm outline-none pr-10" placeholder="••••••••">
            <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs hover:text-white">
                <i class="fas fa-eye"></i>
            </button>
            @error('password')
                <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="relative bg-black/30 border border-gray-600 rounded-lg px-3 py-2">
            <label for="password_confirmation" class="block text-xs font-medium text-gray-200 mb-0.5">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full bg-transparent text-white text-sm outline-none pr-10" placeholder="••••••••">
            <button type="button" onclick="toggleConfirmPassword()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs hover:text-white">
                <i class="fas fa-eye"></i>
            </button>
            @error('password_confirmation')
                <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
       <button id="resetBtn" type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-full transition duration-300 flex items-center justify-center space-x-2">
    <span>Reset My Password</span>
    <svg id="spinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 11-8 8z"/>
    </svg>
</button>

    </form>

    <!-- Back to login -->
    <div class="text-center text-xs text-gray-300">
        Remember your password?
        <a href="{{ route('login') }}" class="text-blue-400 font-semibold hover:underline">Login</a>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const icon = password.nextElementSibling.querySelector('i');
        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    function toggleConfirmPassword() {
        const passwordConfirm = document.getElementById('password_confirmation');
        const icon = passwordConfirm.nextElementSibling.querySelector('i');
        if (passwordConfirm.type === 'password') {
            passwordConfirm.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordConfirm.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Show loading on form submit
    document.querySelector('form').addEventListener('submit', function () {
        const btn = document.getElementById('resetBtn');
        const spinner = document.getElementById('spinner');
        btn.disabled = true;
        btn.classList.add('opacity-70', 'cursor-not-allowed');
        spinner.classList.remove('hidden');
        btn.querySelector('span').textContent = 'Resetting...';
    });
</script>
@endsection

