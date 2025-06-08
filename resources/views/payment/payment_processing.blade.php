@extends('layouts.employee')

@section('content')

<div class="py-16 px-6 max-w-3xl mx-auto text-center">
    <!-- Header -->
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Processing Your Payment</h1>
    <p class="text-gray-600 mb-6">We're finalizing your transaction. Please hold tight and do not close this page.</p>

    <!-- Spinner Animation -->
    <div class="flex justify-center mb-6">
        <div class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
    </div>

    <!-- Progress Text -->
    <p class="text-gray-500 text-sm animate-pulse">This might take up to 10 seconds...</p>

    <!-- Optional: Add loading bar -->
    <div class="mt-6 w-2/3 mx-auto h-2 bg-gray-200 rounded-full overflow-hidden">
        <div id="loadingBar" class="h-full bg-blue-600 transition-all duration-1000" style="width: 0%;"></div>
    </div>
</div>

<script>
    // Animate loading bar
    let progress = 0;
    const bar = document.getElementById("loadingBar");
    const interval = setInterval(() => {
        progress += 10;
        bar.style.width = progress + "%";
        if (progress >= 100) clearInterval(interval);
    }, 900); // Simulates a 9-second progress bar

    // Simulate payment processing result
    setTimeout(() => {
        let paymentSuccessful = Math.random() > 0.5;

        const url = paymentSuccessful
            ? "{{ route('payment.success', ['transaction_id' => strtoupper(uniqid()), 'plan' => request()->query('plan'), 'amount' => request()->query('amount')]) }}"
            : "{{ route('payment.failed') }}";

        window.location.href = url;
    }, 9000);
</script>

@endsection
