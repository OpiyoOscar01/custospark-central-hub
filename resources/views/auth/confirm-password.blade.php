@extends('auth.auth-main')

@section('title', 'Confirm Password')

@section('content')

<div class="w-full max-w-md px-6 py-8 bg-white bg-opacity-10 backdrop-blur-md shadow-2xl rounded-2xl border border-white border-opacity-30 transform transition-transform duration-500 hover:scale-[1.02]">

    <!-- Logo -->
    <div class="flex justify-center mb-6">
        <img src="{{ asset('images/v8.png') }}" alt="Custospark Logo" class="w-20 h-20 rounded-full shadow-lg border border-white/30">
    </div>

    <!-- Headings -->
    <h1 class="text-white text-3xl font-bold text-center mb-2">Confirm Password</h1>
    <p class="text-white text-sm text-center opacity-80 mb-6">
        For your security, please confirm your password before continuing.
    </p>

    <!-- Password Confirmation Form -->
    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-white mb-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full px-4 py-3 rounded-lg bg-white bg-opacity-20 text-white placeholder-white/80 border border-white/30 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent">
            @error('password')
                <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-end">
            <button type="submit"
                class="px-5 py-2 bg-indigo-600 text-white font-medium text-sm rounded-md hover:bg-indigo-700 shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-400">
                Confirm Password
            </button>
        </div>
    </form>

</div>

@endsection
