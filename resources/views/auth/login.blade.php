@extends('auth.auth-main')

@section('title', 'Login')

@section('content')
<div class="w-full max-w-md mx-auto bg-black/40 backdrop-blur-md border border-white/20 rounded-xl shadow-xl p-6 space-y-6">

  <!-- Logo -->
  <div class="text-center">
    <a href="/" class="inline-flex items-center space-x-2">
      <img src="{{ asset('images/v8.png') }}" alt="Custospark Logo" class="w-16 h-16 rounded-full border border-white/20 shadow">
      <span class="text-xl font-bold text-blue-400">Custospark</span>
    </a>
  </div>

  <!-- Welcome Text -->
  <p class="text-center text-white text-sm">
    @if (!empty($appName) && strtolower($appName) !== 'the app')
      Sign in to continue to <span class="text-blue-400">{{ ucfirst($appName) }}</span>.
    @else
      Welcome to <span class="text-blue-400">Custospark</span>
    @endif
  </p>

  <!-- Login Form -->
  <form id="login-form" method="POST" action="{{ route('login') }}" class="space-y-5">
    @csrf
    <input type="hidden" name="app" value="{{ $appName ?? 'custospark' }}"/>

    <!-- Email -->
    <div>
      <label for="email" class="block text-xs text-gray-300 mb-1">Email</label>
      <div class="relative bg-black/20 border border-gray-600 rounded-lg px-3 py-1.5">
        <input
          id="email"
          name="email"
          type="email"
          placeholder="you@example.com"
          required
          class="w-full bg-transparent text-white text-sm placeholder-gray-400 outline-none"
        >
        <i class="fas fa-envelope absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
      </div>
      @error('email')
        <span class="text-red-400 text-xs">{{ $message }}</span>
      @enderror
    </div>

    <!-- Password -->
    <div>
      <label for="password" class="block text-xs text-gray-300 mb-1">Password</label>
      <div class="relative bg-black/20 border border-gray-600 rounded-lg px-3 py-1.5">
        <input
          id="password"
          name="password"
          type="password"
          placeholder="••••••••"
          required
          class="w-full bg-transparent text-white text-sm outline-none pr-8"
        >
        <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white text-xs focus:outline-none">
          <i class="fas fa-eye"></i>
        </button>
      </div>
      @error('password')
        <span class="text-red-400 text-xs">{{ $message }}</span>
      @enderror
    </div>

    <!-- Remember & Forgot -->
    <div class="flex items-center justify-between text-xs text-gray-300">
      <label class="inline-flex items-center space-x-2">
        <input type="checkbox" name="remember" class="rounded text-blue-500 focus:ring-0">
        <span>Remember me</span>
      </label>
      <a href="{{ route('password.request') }}" class="text-blue-400 hover:underline">Forgot Password?</a>
    </div>

<p class="text-xs text-center text-yellow-300 italic"> 🔒 All credentials are encrypted and we offer 2FA for extra security.</p>
  

    <!-- Submit Button -->
    <button id="login-button" type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2.5 rounded-full flex items-center justify-center space-x-2 text-sm">
      <svg id="spinner" class="hidden animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8z"/>
      </svg>
      <span id="login-text">Login</span>
    </button>
  </form>

  <!-- Divider -->
  <div class="flex items-center text-gray-400 text-xs">
    <hr class="flex-grow border-white/20">
    <span class="px-2">or continue with</span>
    <hr class="flex-grow border-white/20">
  </div>

  <!-- Social Login -->
  <div class="grid grid-cols-2 gap-2">
    <a href="{{ route('social.redirect', 'google') }}" class="bg-white text-gray-800 py-1.5 rounded-full text-sm flex items-center justify-center space-x-2 border border-gray-300 hover:bg-gray-100">
      <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" class="w-4 h-4">
      <span>Google</span>
    </a>
    {{-- <a href="{{ route('social.redirect', 'github') }}" class="bg-gray-800 text-white py-1.5 rounded-full text-sm flex items-center justify-center space-x-2 hover:bg-gray-900">
      <i class="fab fa-github text-base"></i>
      <span>GitHub</span>
    </a> --}}
      {{-- To be implemented later --}}
    <!-- Facebook -->
  {{-- <a href="#" class="bg-[#1877F2] hover:bg-[#166FE0] text-white font-semibold py-2 rounded-full flex items-center justify-center space-x-3 transition">
    <i class="fab fa-facebook-f text-lg"></i>
    <span>Facebook</span>
  </a> --}}

  <!-- Microsoft -->
  {{-- <a href="#" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 rounded-full flex items-center justify-center space-x-3 border border-gray-300 transition">
    <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg" alt="Microsoft" class="w-5 h-5">
    <span>Microsoft</span>
  </a> --}}

  <!-- Apple -->
  {{-- <a href="#" class="bg-black hover:bg-gray-900 text-white font-semibold py-2 rounded-full flex items-center justify-center space-x-3 transition">
    <i class="fab fa-apple text-lg"></i>
    <span>Apple</span>
  </a> --}}
  {{-- <a href="#" class="bg-[#1DA1F2] hover:bg-[#0d8ddb] text-white font-semibold py-2 rounded-full flex items-center justify-center space-x-3 transition">
  <i class="fab fa-x-twitter text-lg"></i>
  <span>X</span>
</a> --}}
  </div>

  <!-- Register Prompt -->
  <p class="text-center text-xs text-gray-300">
    No account?
    <a href="{{ route('register') }}" class="text-blue-400 font-semibold hover:underline">Sign up</a>
  </p>
</div>
@endsection

@section('scripts')
<script>
  function togglePassword() {
    const passwordField = document.getElementById('password');
    const icon = passwordField.nextElementSibling.querySelector('i');
    const isHidden = passwordField.type === 'password';

    passwordField.type = isHidden ? 'text' : 'password';
    icon.classList.toggle('fa-eye', !isHidden);
    icon.classList.toggle('fa-eye-slash', isHidden);
  }

  document.getElementById('login-form').addEventListener('submit', function () {
    const btn = document.getElementById('login-button');
    const spinner = document.getElementById('spinner');
    const text = document.getElementById('login-text');

    btn.disabled = true;
    spinner.classList.remove('hidden');
    text.textContent = 'Logging in...';
  });
</script>
@endsection
