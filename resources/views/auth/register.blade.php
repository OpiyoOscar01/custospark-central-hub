@extends('auth.auth-main')

@section('title', 'Register')

@section('content')
<div class="w-full max-w-sm bg-black/50 backdrop-blur-lg border border-white/30 rounded-xl shadow-2xl p-6">

    <!-- Logo -->
    <div class="text-center mb-4">
        <a href="/" class="inline-flex items-center space-x-2">
            <img src="{{ asset('images/v8.png') }}" alt="Custospark Logo" class="w-14 h-14 rounded-full shadow-lg border border-white/30">
            <span class="text-xl font-semibold text-blue-400">Custospark</span>
        </a>
    </div>

<div class="text-center mb-2">
  <h3 class="text-xl font-bold text-white">Welcome to Custospark</h3>
  <h5 class="text-sm italic text-blue-500">Please sign up to access all our smart tools and services.</h5>

</div>


    <!-- Register Form -->
    <form id="register-form" method="POST" action="{{ route('register.store') }}" class="space-y-3">
        @csrf

        <!-- Input Group (same as before, just smaller spacing) -->
        @foreach ([
            ['first_name', 'First Name', 'given-name'],
            ['last_name', 'Last Name', 'family-name'],
            ['email', 'Email', 'email'],
        ] as [$id, $label, $autocomplete])
            <div class="relative border border-gray-600 bg-black/30 rounded-lg px-3 py-1.5">
                <label for="{{ $id }}" class="block text-xs font-medium text-gray-200 mb-1">{{ $label }}</label>
                <input id="{{ $id }}" type="{{ $id === 'email' ? 'email' : 'text' }}" name="{{ $id }}" value="{{ old($id) }}"
                    required autocomplete="{{ $autocomplete }}" class="w-full bg-transparent text-white outline-none text-sm">
                @error($id)
                    <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                @enderror
            </div>
        @endforeach

        <!-- Passwords -->
        @foreach ([
            ['password', 'Password'],
            ['password_confirmation', 'Confirm Password']
        ] as [$id, $label])
            <div class="relative border border-gray-600 bg-black/30 rounded-lg px-3 py-1.5">
                <label for="{{ $id }}" class="block text-xs font-medium text-gray-200 mb-1">{{ $label }}</label>
                <input id="{{ $id }}" type="password" name="{{ $id }}" required autocomplete="new-password"
                    class="w-full bg-transparent text-white outline-none text-sm pr-8">
                <button type="button" onclick="togglePassword('{{ $id }}', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white">
                    <i class="fas fa-eye text-xs"></i>
                </button>
                @error($id)
                    <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                @enderror
            </div>
        @endforeach

        <!-- Submit -->
        <button id="register-button" type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 rounded-full transition text-sm flex items-center justify-center space-x-2">
            <svg id="register-spinner" class="hidden animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8z"/>
            </svg>
            <span id="register-text">Register</span>
        </button>
    </form>

    <!-- Login redirect -->
    <div class="text-center mt-4 text-gray-300 text-xs">
        Already have an account? <a href="{{ route('login') }}" class="text-blue-400 font-medium hover:underline">Login</a>
    </div>
</div>

@endsection

@section('scripts')
<script>
  // Toggle password visibility for inputs with buttons
  function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
  }

  // Show spinner and disable submit button on form submit
  document.getElementById('register-form').addEventListener('submit', function () {
    const button = document.getElementById('register-button');
    const spinner = document.getElementById('register-spinner');
    const text = document.getElementById('register-text');

    button.disabled = true;
    spinner.classList.remove('hidden');
    text.textContent = 'Registering...';
  });
</script>
@endsection
