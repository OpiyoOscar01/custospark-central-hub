@extends('layouts.employee')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-white text-blue-600">
    <!-- Header -->
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold">
            <i class="bi bi-box text-blue-600"></i> Power Up with Custospace Plans
        </h1>
        <p class="mt-2 text-lg font-medium text-gray-800">Flexible storage & collaboration for every team. Cancel anytime.</p>
    </div>

    <!-- Billing Toggle -->
    <div class="flex justify-center mb-8">
        <span class="mr-3 font-medium text-gray-800">Billing:</span>
        <div class="inline-flex bg-gray-100 rounded-full overflow-hidden shadow-inner">
            <button id="monthlyBtn" class="px-6 py-2 text-sm font-semibold bg-blue-600 text-white focus:outline-none transition">Monthly</button>
            <button id="yearlyBtn" class="px-6 py-2 text-sm font-semibold text-blue-600 focus:outline-none transition">Yearly</button>
        </div>
    </div>

    <!-- Pricing Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @php
            $currentPlan = 'Free'; // Example
            $plans = [
                ['name' => 'Free', 'monthly' => 0, 'features' => ['1 GB storage', 'Basic sharing', 'Community support'], 'user' => 'Casual users'],
                ['name' => 'Starter', 'monthly' => 10, 'features' => ['50 GB storage', 'Private folders', 'Email support'], 'user' => 'Freelancers'],
                ['name' => 'Team', 'monthly' => 35, 'features' => ['500 GB storage', 'Team folders', 'Advanced permissions'], 'user' => 'Small teams'],
                ['name' => 'Enterprise', 'monthly' => 120, 'features' => ['Unlimited storage', 'Admin tools', 'Priority support'], 'user' => 'Large organizations'],
            ];
        @endphp

        @foreach ($plans as $plan)
        <div class="border rounded-xl shadow-md p-6 flex flex-col justify-between bg-white text-blue-600 border-gray-300 hover:shadow-xl transition">
            <div>
                <h2 class="text-xl font-bold mb-2">
                    <i class="bi bi-check-circle-fill text-blue-600"></i> {{ $plan['name'] }}
                </h2>
                <p class="text-3xl font-semibold mb-4 text-gray-800 price" data-monthly="{{ $plan['monthly'] }}">
                    ${{ $plan['monthly'] }}/mo
                </p>

                <ul class="list-unstyled text-gray-700 space-y-1 mb-2">
                    @foreach ($plan['features'] as $feature)
                        <li><i class="bi bi-check-lg text-blue-600"></i> {{ $feature }}</li>
                    @endforeach
                </ul>
                <p class="text-sm text-gray-600">
                    <i class="bi bi-person"></i> Ideal for: {{ $plan['user'] }}
                </p>
            </div>

            <div class="mt-6">
                @if ($plan['name'] === $currentPlan)
                    <span class="block w-full text-center bg-gray-200 text-gray-600 py-2 rounded font-medium cursor-default">
                        <i class="bi bi-patch-check"></i> Current Plan
                    </span>
                @else
                    <a href="{{ route('payment.checkout') }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded font-medium shadow transition">
                        <i class="bi bi-arrow-up-right-circle"></i> Upgrade to {{ $plan['name'] }}
                    </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Trust Boosters -->
    <div class="mt-12 text-center text-gray-700 space-y-1">
        <p><i class="bi bi-lock-fill text-blue-600"></i> Secure cloud infrastructure</p>
        <p><i class="bi bi-shield-check text-blue-600"></i> Cancel anytime, no contracts</p>
        <p><i class="bi bi-chat-right-text text-blue-600"></i> Need help? <a href="#" class="text-blue-600 font-semibold">Contact support</a></p>
    </div>
</div>

<script>
    const prices = document.querySelectorAll('.price');
    const monthlyBtn = document.getElementById('monthlyBtn');
    const yearlyBtn = document.getElementById('yearlyBtn');

    monthlyBtn.addEventListener('click', () => {
        prices.forEach(el => {
            const monthly = parseInt(el.dataset.monthly);
            el.textContent = `$${monthly}/mo`;
        });

        monthlyBtn.classList.add('bg-blue-600', 'text-white');
        monthlyBtn.classList.remove('text-blue-600');
        yearlyBtn.classList.remove('bg-blue-600', 'text-white');
        yearlyBtn.classList.add('text-blue-600');
    });

    yearlyBtn.addEventListener('click', () => {
        prices.forEach(el => {
            const monthly = parseInt(el.dataset.monthly);
            const yearly = monthly * 10;
            el.textContent = `$${yearly}/yr`;
        });

        yearlyBtn.classList.add('bg-blue-600', 'text-white');
        yearlyBtn.classList.remove('text-blue-600');
        monthlyBtn.classList.remove('bg-blue-600', 'text-white');
        monthlyBtn.classList.add('text-blue-600');
    });
</script>
@endsection
