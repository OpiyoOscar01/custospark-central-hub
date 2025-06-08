@extends('errors.layout')
@section('title', '419 Page Expired')
@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 text-center px-4 py-12">
    <h1 class="text-6xl font-bold text-orange-500 mb-4">419</h1>
    <p class="text-2xl font-semibold text-gray-800 mb-2">Page Expired</p>
    <p class="text-gray-600 mb-6">
        Your session has expired. This usually happens if you were inactive for too long or submitted a form twice.
    </p>

    @if(Auth::check())
        <a href="{{ route('dashboard') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
            Back to Dashboard
        </a>
    @else
        <a href="{{ route('login.redirect',['app'=>'custospark']) }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
            Login Again
        </a>
    @endif
</div>
@endsection
