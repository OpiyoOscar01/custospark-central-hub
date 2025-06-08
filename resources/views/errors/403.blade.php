@extends('errors.layout')

@section('title', '403 Forbidden')

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
    <h1 class="text-6xl md:text-7xl font-extrabold text-blue-600 mb-4">403</h1>

    <!-- Headline -->
    <p class="text-2xl md:text-3xl font-semibold text-gray-800 mb-2">Access Denied</p>

    <!-- Message -->
    <p class="text-gray-600 max-w-xl mx-auto mb-6">
        You don’t have permission to view this page or perform this action. If you believe this is a mistake, please contact support.
    </p>

    <!-- Redirect Buttons -->
    @if(Auth::check())
        <a href="{{ route('dashboard') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
            Go to Dashboard
        </a>
    @else
        <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
            Go to Homepage
        </a>
    @endif

    <!-- Support Note -->
    <p class="mt-8 text-sm text-gray-500">
        Need help? Contact us at 
        <a href="mailto:support@custospark.com" class="text-indigo-600 hover:underline">support@custospark.com</a>
    </p>
</div>
@endsection
