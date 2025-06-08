@extends('layouts.employee')

@section('content')

<div class="py-10 px-6 max-w-7xl mx-auto text-center">
    <!-- Error Icon -->
    <div class="mb-6">
        <i class="bi bi-exclamation-circle text-red-500 text-5xl"></i>
    </div>

    <!-- Failure Message -->
    <h1 class="text-3xl font-extrabold text-gray-900">Payment Failed</h1>
    <p class="text-gray-600 mt-2">Oops,<span class="text-blue-500">{{ Auth::user()->name }}</span>! Your payment was not processed.</p>

    <!-- Possible Reasons -->
    <div class="max-w-full mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-200 mt-6 text-left">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Possible Reasons:</h2>
        <ul class="list-none text-gray-600 space-y-2">
            <li><i class="bi bi-x-circle text-red-500"></i> Insufficient funds in account.</li>
            <li><i class="bi bi-wifi-off text-red-500"></i> Network or connectivity issues.</li>
            <li><i class="bi bi-credit-card text-red-500"></i> Card declined by your bank.</li>
            <li><i class="bi bi-clock text-red-500"></i> Payment timeout due to inactivity.</li>
        </ul>
    </div>

    <!-- Retry Payment -->
    <div class="mt-6 text-center">
        <p class="text-gray-600">You can try again or choose a different payment method.</p>
    </div>

    <!-- Action Buttons -->
    <div class="mt-6 flex justify-center space-x-4">
        <a href="{{ route('payment.checkout', ['plan' => request()->query('plan')]) }}" 
           class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            Retry Payment
        </a>
        <a href="#" 
           class="px-6 py-3 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-700 transition">
            Contact Support
        </a>
    </div>

    <!-- Secure Payment Assurance -->
    <div class="mt-8 text-center text-gray-500 text-sm">
        <i class="bi bi-lock-fill text-red-500"></i> Your payment is securely processed. If the issue persists, please contact support.
    </div>
</div>

@endsection
