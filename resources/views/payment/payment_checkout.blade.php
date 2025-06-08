@extends('layouts.employee')

@section('content')

<div class="py-10 px-6 max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="text-center mb-6">
        <h1 class="text-2xl font-extrabold text-gray-900">Upgrade Your Plan</h1>
        <p class="text-gray-600">Complete your payment to unlock premium features.</p>
    </div>

    <!-- Payment Container -->
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-200">
        @php
            // Fetch selected plan from request
            $selectedPlan = request()->query('plan') ?? 'Free Plan';

            $plans = [
                'Free Plan' => ['price' => 0, 'features' => ['Basic features', 'Limited access']],
                'Starter'   => ['price' => 10, 'yearly' => 100, 'features' => ['Up to 5 properties', 'Rent tracking', 'Mobile access']],
                'Professional' => ['price' => 30, 'yearly' => 280, 'features' => ['Up to 20 properties', 'Maintenance tracking', 'Automated billing']],
                'Enterprise' => ['price' => 80, 'yearly' => 800, 'features' => ['Unlimited properties', 'Team accounts', 'Advanced analytics']],
            ];
            
            // Provide default values to prevent errors
            $planDetails = $plans[$selectedPlan] ?? $plans['Free Plan'];
            $monthlyPrice = $planDetails['price'];
            $yearlyPrice = $planDetails['yearly'] ?? $monthlyPrice * 10; // Default yearly price
        @endphp

        <!-- Selected Plan Summary -->
        <div class="text-center mb-4">
            <h2 class="text-xl font-bold text-blue-600">{{ $selectedPlan }}</h2>
            <p class="text-3xl font-semibold text-gray-800 price">${{ $monthlyPrice }}/mo</p>
        </div>

        <!-- Features List -->
        <ul class="list-none text-gray-600 space-y-2 mb-6">
            @foreach ($planDetails['features'] as $feature)
                <li><i class="bi bi-check-circle text-green-500"></i> {{ $feature }}</li>
            @endforeach
        </ul>

        <!-- Billing Cycle Toggle -->
        <div class="flex justify-center mb-6">
            <div class="inline-flex bg-gray-100 rounded-full overflow-hidden shadow-inner">
                <button id="monthlyBtn" class="px-6 py-2 text-sm font-semibold bg-blue-600 text-white">Monthly</button>
                <button id="yearlyBtn" class="px-6 py-2 text-sm font-semibold text-blue-600">Yearly</button>
            </div>
        </div>

        <!-- Payment Method Selection -->
        <div class="text-center mb-6">
            <p class="text-gray-700 font-semibold mb-2">Choose Payment Method:</p>
            <div class="grid grid-cols-3 gap-4">
                <button onclick="showPaymentForm('mobile-money')" class="p-3 bg-gray-50 hover:bg-blue-100 border rounded-lg transition">Mobile Money</button>
                <button onclick="showPaymentForm('card')" class="p-3 bg-gray-50 hover:bg-blue-100 border rounded-lg transition">Card</button>
                <button onclick="showPaymentForm('bank')" class="p-3 bg-gray-50 hover:bg-blue-100 border rounded-lg transition">Bank Transfer</button>
            </div>
        </div>

        <!-- Mobile Money Form -->
        <form id="mobile-money-form" action="{{ route('payment.process') }}" method="POST" class="hidden mt-6">
            @csrf
            <h3 class="text-blue-600 font-semibold text-lg mb-2">Mobile Money Payment</h3>
            <input type="tel" name="phone" placeholder="Enter Mobile Number" required class="w-full px-4 py-2 border rounded-lg mb-3">
            <input type="hidden" name="amount" value="{{ $monthlyPrice }}">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg">Confirm Payment</button>
        </form>

        <!-- Card Payment Form -->
        <form id="card-form" action="{{ route('payment.process') }}" method="POST" class="hidden mt-6">
            @csrf
            <h3 class="text-blue-600 font-semibold text-lg mb-2">Card Payment</h3>
            <input type="text" name="card_number" placeholder="Card Number" required class="w-full px-4 py-2 border rounded-lg mb-3">
            <input type="text" name="card_expiry" placeholder="Card Expiry (MM/YY)" required class="w-full px-4 py-2 border rounded-lg mb-3">
            <input type="text" name="card_cvv" placeholder="CVV Code" required class="w-full px-4 py-2 border rounded-lg mb-3">
            <input type="hidden" name="amount" value="{{ $monthlyPrice }}">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg">Confirm Payment</button>
        </form>

        <!-- Bank Transfer Info -->
        <div id="bank-form" class="hidden mt-6">
            <h3 class="text-blue-600 font-semibold text-lg mb-2">Bank Transfer Details</h3>
            <p class="text-gray-700">Account Name: Custospark Payments</p>
            <p class="text-gray-700">Bank: XYZ Bank</p>
            <p class="text-gray-700">Account Number: 1234567890</p>
            <p class="text-gray-700">Reference: {{ Auth::user()->name }} - {{ $selectedPlan }}</p>
        </div>
    </div>
</div>

<script>
    function showPaymentForm(method) {
        document.getElementById("mobile-money-form").classList.add("hidden");
        document.getElementById("card-form").classList.add("hidden");
        document.getElementById("bank-form").classList.add("hidden");

        document.getElementById(method + "-form").classList.remove("hidden");
    }
</script>

@endsection