@extends('auth.auth-main')

@section('title', 'Forgot Password')

@section('styles')
<style>
    .code-input::-webkit-inner-spin-button,
    .code-input::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
@endsection

@section('content')
<div class="w-full px-4 sm:px-6 md:px-8 flex justify-center">
    <div class="w-full max-w-md bg-black/50 backdrop-blur-lg border border-white/30 rounded-2xl shadow-2xl p-8 space-y-6">
        
        <!-- Logo -->
        <div class="text-center space-y-2">
            <a href="/" class="inline-flex items-center justify-center space-x-2">
                <img src="{{ asset('images/v8.png') }}" alt="Custospark Logo"
                     class="w-16 h-16 rounded-full shadow-lg border border-white/30 sm:w-20 sm:h-20 md:w-24 md:h-24 lg:w-32 lg:h-32">
                <span class="text-lg font-bold text-white sm:text-xl md:text-2xl lg:text-3xl">
                   <span class="text-blue-400"> Custospark</span>
                </span>
            </a>
        </div>

        <!-- Headings -->
        <div class="text-center space-y-1">
            <h1 class="text-2xl font-bold text-blue-300">Forgot Password?</h1>
            <p class="text-sm text-gray-200">Enter your email address to receive a password reset link.</p>
        </div>

        <!-- Flash Messages -->
        @foreach (['info' => 'blue-500', 'success' => 'green-500', 'error' => 'red-500'] as $type => $color)
            @if (session($type))
                <div class="text-{{ $color }} text-sm font-medium text-center">
                    {{ session($type) }}
                </div>
            @endif
        @endforeach
        @if (session('status'))
            <div class="text-green-400 text-sm font-medium text-center">
                {{ session('status') }}
            </div>
        @endif

        <!-- Forgot Password Form -->
        <form method="POST" action="{{ route('password.email') }}" id="forgot-form" class="space-y-5">
            @csrf

            <div class="relative border border-gray-600 bg-black/30 rounded-lg px-4 py-3 focus-within:ring-2 focus-within:ring-blue-500 transition">
                <label for="email" class="block text-xs font-medium text-gray-200 mb-1">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full bg-transparent text-white outline-none placeholder-gray-400"
                    placeholder="you@example.com">
                @error('email')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button with spinner -->
            <button type="submit" id="submit-button"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-full transition duration-300 text-base sm:text-lg md:text-xl flex justify-center items-center gap-2 disabled:opacity-50"
                {{ session('status') ? 'disabled' : '' }}>
                <svg id="spinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <span id="button-text">Send Password Reset Link</span>
            </button>
        </form>

        <!-- Countdown and Info -->
        <div class="text-center text-sm text-blue-500 space-y-2">
            <p id="countdown" style="display: none;">You can request another link in <span id="timer">60</span>s</p>
        </div>

        <!-- Back to Login -->
        <div class="text-center text-gray-300 text-sm">
            Remembered your password?
            <a href="{{ route('login') }}" class="text-blue-400 font-semibold hover:underline">
                Login
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const submitButton = document.getElementById('submit-button');
    const spinner = document.getElementById('spinner');
    const buttonText = document.getElementById('button-text');
    const countdownText = document.getElementById('countdown');
    const timerElement = document.getElementById('timer');

    // Track if it's a resend
    let isResending = false;

    // Set initial/default button text
    const defaultText = 'Send Reset Link';
    const resendText = 'Send New Reset Link';

    // Submit handler
    document.getElementById('forgot-form').addEventListener('submit', function () {
        submitButton.disabled = true;
        spinner.classList.remove('hidden');
        buttonText.textContent = isResending ? 'Resending...' : 'Sending...';
    });

    @if (session('status'))
        let countdown = 60;
        countdownText.style.display = 'block';
        submitButton.style.display = 'none'; // Hide button

        const interval = setInterval(() => {
            countdown--;
            timerElement.textContent = countdown;
            countdownText.textContent = `Please wait ${countdown}s before requesting again.`;

            if (countdown <= 0) {
                clearInterval(interval);

                // Show resend state
                countdownText.style.display = 'none';
                submitButton.style.display = 'inline-block';
                submitButton.disabled = false;
                spinner.classList.add('hidden');
                buttonText.textContent = resendText;
                isResending = true;
            }
        }, 1000);
    @else
        // Reset to default state
        countdownText.style.display = 'none';
        submitButton.disabled = false;
        spinner.classList.add('hidden');
        buttonText.textContent = defaultText;
        isResending = false;
    @endif
</script>


@endsection
