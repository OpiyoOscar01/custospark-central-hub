@extends('layouts.employee')

@section('content')

<div class="py-10 px-6 max-w-full mx-auto text-center">
    <!-- Success Icon -->
    <div class="mb-6">
        <i class="bi bi-check-circle text-green-500 text-5xl"></i>
    </div>

    <!-- Success Message -->
    <h1 class="text-3xl font-extrabold text-green-500">Payment Successful!</h1>
    <p class="text-gray-900 mt-2">Thank you, <span class="text-blue-500">{{ Auth::user()->name }}</span>! Your plan has been upgraded.</p>

    <!-- Receipt Summary -->
    @php
        $transactionId = request()->query('transaction_id') ?? 'TXN' . strtoupper(uniqid());
        $selectedPlan = request()->query('plan') ?? 'Starter';
        $amountPaid = request()->query('amount') ?? '$10'; // Fetch amount from transaction
    @endphp

    <div class="max-w-full mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-200 mt-6 text-left">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Transaction Details</h2>
        <p class="text-gray-700"><strong>Plan:</strong> {{ $selectedPlan }}</p>
        <p class="text-gray-700"><strong>Amount Paid:</strong> {{ $amountPaid }}</p>
        <p class="text-gray-700"><strong>Transaction ID:</strong> {{ $transactionId }}</p>
    </div>

    <!-- Next Steps -->
    <div class="mt-6 text-center">
        <p class="text-gray-600">You now have access to all features of the {{ $selectedPlan }} plan.</p>
        <p class="text-gray-600">Start exploring now or return to your dashboard.</p>
    </div>

    <!-- Action Buttons -->
    <div class="mt-6 flex justify-center space-x-4">
        <a href="{{route('dashboard') }}" class="px-6 py-3 bg-gray-900 text-blue-500 rounded-lg shadow hover:bg-gray-700 transition">
            Return to Dashboard
        </a>
        <a href="#" class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            Explore Features
        </a>
    </div>
    <!-- Secure Payment Assurance -->
    <div class="mt-8 text-center text-gray-500 text-sm">
        <i class="bi bi-lock-fill text-green-500"></i> Your payment has been securely processed. If you have any questions, <a href="#" class="text-blue-600 font-semibold">contact support</a>.
    </div>
</div>

@endsection
