@extends('errors.layout')

@section('title', '500 Internal Server Error')

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
    <h1 class="text-6xl md:text-7xl font-extrabold text-blue-600 mb-4">500</h1>

    <!-- Headline -->
    <p class="text-2xl md:text-3xl font-semibold text-gray-800 mb-2">Something went wrong</p>

    <!-- Description -->
    <p class="text-gray-600 max-w-xl mx-auto mb-6">
        We're currently experiencing technical difficulties. Please give us a moment and try again shortly.
    </p>

    <!-- Button Logic -->
    @php
        $isLoggedIn = $isLoggedIn ?? auth()->check();
    @endphp

    @if($isLoggedIn)
        <a href="{{ route('dashboard') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
            Back to Dashboard
        </a>
    @else
        <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
            Back to Homepage
        </a>
    @endif

    <!-- Support -->
    <p class="mt-8 text-sm text-gray-500">
        If this issue persists, contact our support team at 
        <a href="mailto:support@custospark.com" class="text-indigo-600 hover:underline">support@custospark.com</a>
    </p>
</div>
@endsection
