@extends('auth.auth-main')

@section('title', 'Verify Email')

@section('content')

<div class="w-full max-w-md px-6 py-8 bg-white bg-opacity-10 backdrop-blur-md shadow-2xl rounded-2xl border border-white border-opacity-30 transform transition-transform duration-500 hover:scale-[1.02]">

    <!-- Logo -->
    <div class="flex justify-center mb-6">
        <img src="{{ asset('images/v8.png') }}" alt="Custospark Logo" class="w-20 h-20 rounded-full shadow-lg border border-white/30">
    </div>

    <!-- Headings -->
    <h1 class="text-white text-3xl font-bold text-center mb-2">Verify Your Email</h1>
    <p class="text-white text-sm text-center opacity-80 mb-6">
        Thanks for signing up! Please verify your email address by clicking on the link we just emailed to you.
        Didn’t get the email? We’ll gladly send you another.
    </p>

    <!-- Session Message -->
    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-sm font-medium text-green-400 text-center">
            A new verification link has been sent to the email address you provided during registration.
        </div>
    @endif

    <!-- Actions -->
    <div class="mt-6 flex items-center justify-between">
        <!-- Resend Link Form -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                class="px-5 py-2 bg-indigo-600 text-white font-medium text-sm rounded-md hover:bg-indigo-700 shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-400">
                Resend Email
            </button>
        </form>

        <!-- Logout Form -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="text-sm text-white underline hover:text-indigo-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-400">
                Log Out
            </button>
        </form>
    </div>

</div>

@endsection
