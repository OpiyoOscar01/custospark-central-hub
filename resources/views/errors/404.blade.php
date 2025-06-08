@extends('errors.layout')

@section('title', '404 Page Not Found')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 text-center px-4 py-12">

    <!-- Logo -->
    <div class="mb-2">
        <img src="{{ asset('images/v8.png') }}" alt="Custospark Logo" class="h-16 md:h-20 rounded-full">
    </div>
     <div class="mb-2">
        <h1 class="text-blue-500 text-2xl fw-bold">Custospark</h1>
    </div>

    <!-- Error Code -->
    <h1 class="text-6xl md:text-7xl font-extrabold text-blue-500 mb-4">404</h1>

    <!-- Headline -->
    <p class="text-2xl md:text-3xl font-semibold text-gray-800 mb-2">Page Not Found</p>

    <!-- Message -->
    <p class="text-gray-600 max-w-xl mx-auto mb-6">
        The page you are looking for doesn't exist, may have been moved, or the URL was typed incorrectly. Let's help you get back on track!
    </p>

    <!-- Smart Back Button -->
    @php
        $previous = url()->previous();
        $current = url()->current();
        $fallback = auth()->check() ? route('dashboard') : route('login');
        $backUrl = $previous !== $current ? $previous : $fallback;
    @endphp

    <a href="{{ $backUrl }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
        Go Back
    </a>

    <!-- Support Note -->
    <p class="mt-8 text-sm text-gray-500">
        Still lost? Contact us at 
        <a href="mailto:support@custospark.com" class="text-indigo-600 hover:underline">support@custospark.com</a>
    </p>
</div>
@endsection
