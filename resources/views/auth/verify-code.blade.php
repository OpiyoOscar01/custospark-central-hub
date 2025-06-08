@extends('auth.auth-main')

@section('title', 'Verify Your Code')

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
    <div class="w-full max-w-md bg-black/50 backdrop-blur-lg border border-white/30 rounded-2xl shadow-2xl p-8 space-y-4">

        {{-- Branding --}}
        <div class="text-center space-y-2">
            <a href="/" class="inline-flex items-center justify-center space-x-2">
                <img src="{{ asset('images/v8.png') }}" alt="Custospark Logo"
                     class="w-16 h-16 rounded-full shadow-lg border border-white/30 sm:w-20 sm:h-20 md:w-24 md:h-24 lg:w-32 lg:h-32">
                <span class="text-lg font-bold text-white sm:text-xl md:text-2xl lg:text-3xl">
                    <span class="text-blue-400">Custospark</span>
                </span>
            </a>
        </div>

        {{-- Greeting --}}
        <div class="text-center space-y-1">
            <h1 class="text-2xl font-bold text-blue-300">
                Welcome{{ $user->first_name ? ', ' . $user->first_name : '' }}!
            </h1>
            <p class="text-sm text-gray-200">
                We’ve sent a 6-digit code to <span class="text-blue-400">{{ $user->email }}</span>. Enter it below to continue securely.
            </p>
            <p class="text-xs text-yellow-300 italic">
                🔒 Don’t share your verification code with anyone.
            </p>
        </div>

        {{-- Session Messages --}}
        @foreach (['info' => 'blue-500', 'success' => 'green-500', 'error' => 'red-500'] as $type => $color)
            @if (session($type))
                <div class="text-{{ $color }} text-sm font-medium text-center">{{ session($type) }}</div>
            @endif
        @endforeach
        @if (session('status'))
            <div class="text-green-400 text-sm font-medium text-center">{{ session('status') }}</div>
        @endif

        {{-- Verification Form --}}
        <form method="POST" action="{{ route('verify.code') }}" id="verify-form" class="space-y-5">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}" />

            <div class="grid grid-cols-6 gap-2 sm:gap-3">
                @for ($i = 0; $i < 6; $i++)
                    <input type="text" name="code[]" maxlength="1" pattern="\d*" inputmode="numeric"
                           class="code-input text-center w-full aspect-square rounded-lg border border-gray-500 bg-black/30 text-white text-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                @endfor
            </div>
            @error('code')
                <p class="text-xs text-red-400 text-center mt-2">{{ $message }}</p>
            @enderror

            <button type="submit" id="confirm-btn"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-full transition duration-300 text-base sm:text-lg md:text-xl">
                Confirm My Code
            </button>
        </form>

        {{-- Resend Section --}}
        <div class="text-center text-sm text-gray-300 space-y-2">
            <p id="countdown-text">
            </p>

            <form method="POST" action="{{ route('resend.code') }}" id="resend-form" class="inline-block">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}" />
                <button type="submit" id="resend-btn"
                        class="text-blue-400 font-semibold hover:underline"
                        disabled>
                    Resend Verification Code
                </button>
            </form>
        </div>

        <div class="text-center text-gray-300 text-sm">
            Wrong details? <a href="{{ route('login') }}" class="text-blue-400 font-semibold hover:underline">Back to Login</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const inputs = document.querySelectorAll('.code-input');
    const confirmBtn = document.getElementById('confirm-btn');
    const verifyForm = document.getElementById('verify-form');
    const resendForm = document.getElementById('resend-form');
    const resendBtn = document.getElementById('resend-btn');

    let timerInterval;

    // Auto focus and move
    inputs[0].focus();
    inputs.forEach((input, i) => {
        input.addEventListener('input', () => {
            if (input.value.length === 1 && i < inputs.length - 1) {
                inputs[i + 1].focus();
            }
        });

        input.addEventListener('keydown', e => {
            if (e.key === 'Backspace' && !input.value && i > 0) {
                inputs[i - 1].focus();
            }
        });
    });

    // Form Submit
    verifyForm.addEventListener('submit', function (e) {
        const combined = Array.from(inputs).map(i => i.value).join('');
        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'code';
        hidden.value = combined;
        this.appendChild(hidden);

        confirmBtn.disabled = true;
        confirmBtn.textContent = 'Confirming...';
    });

    // Countdown
    function startCountdown(seconds = 60) {
        let remaining = seconds;
        resendBtn.disabled = true;
        resendBtn.classList.add('cursor-not-allowed', 'opacity-50');
        resendBtn.textContent = `Please wait ${remaining}s to request a new code`;

        timerInterval = setInterval(() => {
            remaining--;
            resendBtn.textContent = `Please wait ${remaining}s to request a new code.`;

            if (remaining <= 0) {
                clearInterval(timerInterval);
                resendBtn.disabled = false;
                resendBtn.classList.remove('cursor-not-allowed', 'opacity-50');
                resendBtn.textContent = "Didn't receive the code? Click to resend.";
            }
        }, 1000);
    }

    // Initial countdown
    startCountdown();

    // Resend Submit
    resendForm.addEventListener('submit', function (e) {
        // e.preventDefault(); // Prevent instant form submit

        resendBtn.disabled = true;
        resendBtn.classList.add('hidden');
        confirmBtn.disabled = true;
        confirmBtn.textContent = 'Resending...';

        this.submit(); // Proceed with actual submission (server handles redirect/refresh)
    });
</script>
@endsection

