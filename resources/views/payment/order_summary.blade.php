@extends('layouts.employee')

@section('content')
@php
    use App\Helpers\CurrencyHelper;

    // --- Base Values ---
    $standardPriceUSD = $plan->price;
    $userCurrency = auth()->user()->preferred_currency ?? 'USD';
    $proratedCreditAmount = $proratedCredit ?? 0;
    $remainingDays = $remainingDays ?? 0;

    // --- Currency Conversions ---
    $convertedUserPrice = CurrencyHelper::convert($standardPriceUSD, $userCurrency);
    $convertedProratedAmount = CurrencyHelper::convert($proratedCreditAmount, $userCurrency);

    // --- Formatted Outputs (USD) ---
    $formattedUSDPrice = CurrencyHelper::format($standardPriceUSD, 'USD');
    $formattedProratedAmountInUSD = CurrencyHelper::format($proratedCreditAmount, 'USD');

    // --- Formatted Outputs (User Currency) ---
    $formattedConvertedUserPrice = CurrencyHelper::format($convertedUserPrice, $userCurrency);
    $formattedProratedAmountInUserCurrency = CurrencyHelper::format($convertedProratedAmount, $userCurrency);

    // --- Coupon Handling ---
    $hasCoupon = session()->has('applied_coupon');
    $discountUSD = $hasCoupon ? session('applied_coupon.discount') : 0;
    $convertedDiscount = CurrencyHelper::convert($discountUSD, $userCurrency);

    $formattedDiscountUSD = CurrencyHelper::format($discountUSD, 'USD');
    $formattedDiscountLocal = CurrencyHelper::format($convertedDiscount, $userCurrency);

    // --- Final Price Calculation ---
    $finalPriceUSD = $standardPriceUSD - $discountUSD - $proratedCreditAmount;
    $convertedFinalPrice = CurrencyHelper::convert($finalPriceUSD, $userCurrency);

    $formattedFinalUSD = CurrencyHelper::format($finalPriceUSD, 'USD');
    $formattedFinalLocal = CurrencyHelper::format($convertedFinalPrice, $userCurrency);
@endphp


<div class="max-w-4xl lg:max-w-7xl mx-auto mt-10 p-6 sm:p-8 bg-white rounded-lg shadow-lg text-gray-800 space-y-6">
        <nav class="mb-6 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('dashboard.pricing.app', ['app' => $app->id]) }}" class="hover:text-gray-700 flex items-center">
            <i class="bi bi-arrow-left-short text-blue-500 text-lg mr-1"></i>
            <span class="text-blue-600 font-medium">{{ $app->name }}</span>
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900 font-medium">{{ $plan->name}} Plan</span>
    </nav>

    {{-- 🌍 Currency Selection --}}
    <form action="{{ route('settings.update.currency') }}" method="POST" class="flex flex-col sm:flex-row justify-end items-start sm:items-center gap-2 sm:gap-4">
        @csrf
        @method('PUT')
        <label for="currency" class="font-medium text-sm text-gray-700 whitespace-nowrap flex items-center gap-1">
            <i class="bi bi-currency-exchange text-blue-500"></i> Preferred Currency:
        </label>
        <select name="currency" id="currency" onchange="this.form.submit()"
            class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 w-full sm:w-auto">
            @foreach (\App\Helpers\CurrencyHelper::getActiveCurrencies() as $currency)
                <option value="{{ $currency->code }}" @selected(auth()->user()->preferred_currency === $currency->code)>
                    {{ $currency->name }} ({{ $currency->code }})
                </option>
            @endforeach
        </select>
    </form>

    {{-- 🧾 Order Summary Header --}}
    <div class="text-center space-y-1">
        <h2 class="text-2xl font-bold text-gray-900 flex justify-center items-center gap-2">
            <i class="bi bi-receipt-cutoff text-blue-600"></i> Order Summary
        </h2>
        <p class="text-gray-600 text-sm">Review your plan details before proceeding to payment.</p>
    </div>

   {{-- 🧾 Plan Summary and Coupon --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- 📋 ORDER SUMMARY (Plan Details & Pricing Breakdown) --}}
    <div class="space-y-4 text-sm sm:text-base bg-white border border-gray-200 rounded-xl p-4">
        {{-- App Info --}}
        <div class="flex items-center gap-2">
            <i class="bi bi-box text-blue-500"></i>
            <span><strong>App:</strong> {{ $app->name }}</span>
        </div>

        {{-- Plan Info --}}
        <div class="flex items-center gap-2">
            <i class="bi bi-card-heading text-blue-500"></i>
            <span><strong>Plan:</strong> {{ $plan->name }}</span>
        </div>

        {{-- Billing Cycle --}}
        <div class="flex items-center gap-2">
            <i class="bi bi-calendar3 text-blue-500"></i>
            <span><strong>Billing:</strong> {{ ucfirst($plan->billing_cycle) }}</span>
        </div>

        {{-- Standard Price --}}
        <div class="flex items-center gap-2">
            <i class="bi bi-cash-stack text-blue-500"></i>
            <span><strong>Price:</strong> {{ $formattedUSDPrice }}</span>
            @if ($userCurrency !== 'USD')
                <span class="text-blue-500">(≈ {{ $formattedConvertedUserPrice }})</span>
            @endif
        </div>

        {{-- Applied Coupon Info --}}
        @if ($hasCoupon)
            <div class="flex items-center gap-2 text-blue-600">
                <i class="bi bi-ticket-perforated-fill"></i>
                <span>
                    <strong>Coupon Discount:</strong> {{ $formattedDiscountUSD }}
                    @if ($userCurrency !== 'USD')
                        <span class="text-blue-600">(≈ {{ $formattedDiscountLocal }})</span>
                    @endif
                </span>
            </div>
        @endif

        {{-- Prorated Credit (from previous plan) --}}
        @if ($proratedCreditAmount)
            <div class="flex items-center gap-2 text-blue-600">
                <i class="bi bi-arrow-repeat"></i>
                <span>
                    <strong>Credit from previous plan:</strong> {{ $formattedProratedAmountInUSD }}
                    @if ($userCurrency !== 'USD')
                        <span class="text-blue-600">(≈ {{ $formattedProratedAmountInUserCurrency }})</span>
                    @endif
                </span>
            </div>
        @endif

        {{-- Final Price --}}
        <div class="flex items-center gap-2 font-semibold text-gray-800">
            <i class="bi bi-receipt text-blue-500"></i>
            <span><strong>Final Amount:</strong> {{ $formattedFinalUSD }}</span>
            @if ($userCurrency !== 'USD')
                <span class="text-blue-500">(≈ {{ $formattedFinalLocal }})</span>
            @endif
        </div>
    </div>

    {{-- 🎟️ COUPON SECTION --}}
    @if (!session()->has('applied_coupon'))
        {{-- Coupon Input Form --}}
        <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl">
            <div class="flex items-start gap-3 mb-3">
                <i class="bi bi-ticket-perforated text-indigo-500 text-xl mt-1"></i>
                <div>
                    <h2 class="text-base font-semibold text-gray-800">Have a coupon?</h2>
                    <p class="text-sm text-gray-600">Enter your coupon code below to apply a discount before proceeding to payment.</p>
                </div>
            </div>

            <form action="{{ route('user.coupon.apply') }}" method="POST" class="flex flex-col sm:flex-row gap-3 sm:items-center">
                @csrf
                <input 
                    type="text" 
                    name="coupon_code" 
                    placeholder="Enter your coupon code..." 
                    class="w-full sm:w-auto flex-grow px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:border-indigo-500 text-sm"
                >
                <input type="hidden" name="app_id" value="{{ $app->id }}">
                <input type="hidden" name="payment_amount" value="{{ $finalPriceUSD }}">

                <button 
                    type="submit" 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                    <i class="bi bi-check-circle"></i> Apply Coupon
                </button>
            </form>

            @if(session('coupon_error'))
                <p class="text-sm text-red-600 mt-2">{{ session('coupon_error') }}</p>
            @endif

            @if(session('coupon_success'))
                <p class="text-sm text-blue-600 mt-2">{{ session('coupon_success') }}</p>
            @endif
        </div>
    @else
        {{-- Coupon Already Applied --}}
        @php $appliedCoupon = session('applied_coupon'); @endphp
        <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3 text-blue-800">
                <i class="bi bi-ticket-perforated-fill text-xl"></i>
                <div>
                    <p class="font-medium">
                        Coupon <strong>{{ $appliedCoupon['code'] }}</strong> applied successfully!
                    </p>
                    <p class="text-sm">
                        You saved <strong>{{ \App\Helpers\CurrencyHelper::format($appliedCoupon['discount'], 'USD') }}</strong>
                    </p>
                </div>
            </div>

            <form action="{{ route('user.coupon.remove') }}" method="POST">
                @csrf
                <button 
                    type="submit" 
                    class="inline-flex items-center gap-1 px-3 py-2 bg-red-100 text-red-700 text-sm font-medium rounded-lg hover:bg-red-200 transition">
                    <i class="bi bi-x-circle"></i> Remove Coupon
                </button>
            </form>
        </div>
    @endif

</div>


    {{-- 🔄 Subscription Status Notice --}}
    @if ($existingSubscription)
        @if ($isUpgrade)
            <div class="p-4 bg-blue-100 border border-blue-300 text-blue-800 rounded-md flex items-start gap-2">
                <i class="bi bi-arrow-up-circle-fill text-blue-600 mt-1"></i>
                <span>You’re upgrading. The final amount reflects credit from your current plan.</span>
            </div>
        @elseif ($isPaidDowngrade)
            <div class="p-4 bg-blue-50 border border-blue-300 text-blue-800 rounded-md flex flex-col gap-2">
                <div class="flex items-center gap-2">
                    <i class="bi bi-arrow-down-circle-fill text-blue-600"></i>
                    <span class="font-semibold">You're scheduling a paid downgrade.</span>
                </div>
                <ul class="list-disc list-inside text-sm space-y-1 pl-4">
                    <li><strong>Pay Now:</strong> Your current plan continues till cycle end. Downgrade takes effect after.</li>
                    <li><strong>Pay Later:</strong> Schedule now, pay anytime before cycle ends. You can cancel before activation.</li>
                </ul>
            </div>
        @endif
    @endif

    {{-- 💳 Payment Options --}}
    <div class="space-y-3">
    @if ($isPaidDowngrade)
        {{-- Pay Now --}}
        <form action="{{ route('payment.initiate', ['app' => $app->id, 'plan' => $plan->id]) }}" method="POST">
            @csrf
            <input type="hidden" name="finalAmount" value="{{ $convertedFinalPrice }}">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-md text-sm font-medium transition flex justify-center items-center gap-1.5">
                <i class="bi bi-credit-card text-base"></i> Pay Now to Activate
            </button>
        </form>

        {{-- Schedule & Pay Later --}}
        <form action="{{ route('subscription.schedule.paylater', ['app' => $app->id, 'plan' => $plan->id]) }}" method="POST">
            @csrf
            <input type="hidden" name="finalAmount" value="{{ $convertedFinalPrice }}">
            <button type="submit" class="w-full bg-blue-100 hover:bg-blue-200 text-blue-700 py-2 px-3 rounded-md text-sm font-medium transition flex justify-center items-center gap-1.5">
                <i class="bi bi-clock-history text-base"></i> Schedule Downgrade & Pay Later
            </button>
        </form>
    @else
        {{-- Regular Payment --}}
        <form action="{{ route('payment.initiate', ['app' => $app->id, 'plan' => $plan->id]) }}" method="POST">
            @csrf
            <input type="hidden" name="finalAmount" value="{{ $convertedFinalPrice ?? $convertedUserPrice }}">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-md text-sm font-medium transition flex justify-center items-center gap-1.5">
                <i class="bi bi-credit-card text-base"></i> Proceed to Payment
            </button>
        </form>
    @endif
</div>


    {{-- 🔒 Payment Assurance --}}
    <div class="mt-4 text-sm text-center text-gray-500 flex justify-center items-center gap-2">
        <i class="bi bi-shield-lock"></i> Secure payment powered by <span class="font-medium text-gray-700">Flutterwave</span>
    </div>
</div>

@endsection
