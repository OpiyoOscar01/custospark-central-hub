@extends('errors.layout')

@section('title', '503 Service Unavailable')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 text-center px-4 py-12">
    
    <!-- Logo -->
    <div class="mb-6">
        <img src="{{ asset('images/v8.png') }}" alt="Custospark Logo" class="h-16 md:h-20 rounded-full">
    </div>

    <!-- Animated Spinner -->
    <div class="mb-6">
        <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-indigo-600 border-opacity-50"></div>
    </div>

    <!-- Error Code -->
    <h1 class="text-6xl md:text-7xl font-extrabold text-blue-500 mb-4">503</h1>
    
    <!-- Message -->
    <p class="text-2xl md:text-3xl font-semibold text-gray-800 mb-3">We'll be right back!</p>
    <p class="text-gray-600 max-w-xl mx-auto mb-4">
        Custospark is currently undergoing scheduled maintenance or experiencing unusually high traffic. We're working hard to get everything back to normal. Thank you for your patience and support!
    </p>

    <!-- Countdown Notice -->
    <p class="text-gray-600 mb-6">
        Retrying automatically in <span id="countdown" class="font-semibold">10</span> seconds...
    </p>

    <!-- Redirect Buttons -->
    @if(Auth::check())
        <a href="{{ route('dashboard') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
            Go to Dashboard
        </a>
    @else
        <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
            Return to Homepage
        </a>
    @endif

    <!-- Support Note -->
    <p class="mt-8 text-sm text-gray-500">
        Need help? Contact us at <a href="mailto:support@custospark.com" class="text-indigo-600 hover:underline">support@custospark.com</a>
    </p>
</div>

<!-- Countdown Script -->
<script>
    let seconds = 10;
    const countdownElement = document.getElementById('countdown');

    const countdownInterval = setInterval(() => {
        seconds--;
        countdownElement.textContent = seconds;

        if (seconds <= 0) {
            clearInterval(countdownInterval);
            location.reload(); // Reloads the page
        }
    }, 1000);
</script>
@endsection
