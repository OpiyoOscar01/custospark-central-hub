@extends('layouts.employee')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-white text-blue-600">
    <!-- Header -->
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold">
            <i class="bi bi-house-gear text-blue-600"></i> Manage Properties Seamlessly with Custohost
        </h1>
        <p class="mt-2 text-lg font-medium text-gray-800">Track rentals, tenants, and payments — all in one place. Cancel anytime.</p>
    </div>

    <!-- Billing Toggle -->
    <div class="flex justify-center mb-8">
        <span class="mr-3 font-medium text-gray-800">Billing:</span>
        <div class="inline-flex bg-gray-100 rounded-full overflow-hidden shadow-inner">
            <button id="monthlyBtn" class="px-6 py-2 text-sm font-semibold bg-blue-600 text-white focus:outline-none transition">Monthly</button>
            <button id="yearlyBtn" class="px-6 py-2 text-sm font-semibold text-blue-600 focus:outline-none transition">Yearly <span class="text-xs ml-1 text-green-600">(Save 20%)</span></button>
        </div>
    </div>

    <!-- Pricing Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @php
            $currentPlan = 'Starter';
            $plans = [
                ['name' => 'Free', 'monthly' => 0, 'features' => ['Manage up to 1 property', 'Tenant reminders', 'Basic reports'], 'user' => 'Personal landlords'],
                ['name' => 'Starter', 'monthly' => 10, 'features' => ['Up to 5 properties', 'Rent tracking', 'Mobile access'], 'user' => 'Small landlords'],
                ['name' => 'Professional', 'monthly' => 30, 'features' => ['Up to 20 properties', 'Maintenance tracking', 'Automated billing'], 'user' => 'Growing agencies'],
                ['name' => 'Enterprise', 'monthly' => 80, 'features' => ['Unlimited properties', 'Team accounts', 'Advanced analytics', 'Priority support'], 'user' => 'Large property firms'],
            ];
        @endphp

        @foreach ($plans as $plan)
        <div class="border rounded-xl shadow-md p-6 flex flex-col justify-between bg-white text-blue-600 border-gray-300 hover:shadow-xl transition">
            <div>
                <h2 class="text-xl font-bold mb-2">
                    <i class="bi bi-building text-blue-600"></i> {{ $plan['name'] }}
                </h2>
                <p class="text-3xl font-semibold mb-1 text-gray-800 price" data-monthly="{{ $plan['monthly'] }}">
                    ${{ $plan['monthly'] }}/mo
                </p>
                <p class="text-sm text-green-600 hidden yearly-discount">
                    <span class="line-through text-gray-500 mr-1">$<span class="old-price"></span>/yr</span> $<span class="new-price"></span>/yr
                </p>

                <ul class="list-unstyled text-gray-700 space-y-1 mb-2 mt-4">
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
                @elseif ($plan['monthly'] === 0)
                    <a href="#" class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white py-2 rounded font-medium shadow transition">
                        <i class="bi bi-box-arrow-in-right"></i> Get Started
                    </a>
                @else
                    <a href="#" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded font-medium shadow transition">
                        <i class="bi bi-arrow-up-right-circle"></i> Upgrade to {{ $plan['name'] }}
                    </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Trust Boosters -->
    <div class="mt-12 text-center text-gray-700 space-y-1">
        <p><i class="bi bi-lock-fill text-blue-600"></i> Data protection for all your properties</p>
        <p><i class="bi bi-shield-check text-blue-600"></i> Cancel anytime, no hidden fees</p>
        <p><i class="bi bi-chat-right-text text-blue-600"></i> Need help? <a href="#" class="text-blue-600 font-semibold">Contact support</a></p>
    </div>
</div>

<script>
    const prices = document.querySelectorAll('.price');
    const oldPrices = document.querySelectorAll('.old-price');
    const newPrices = document.querySelectorAll('.new-price');
    const yearlyDiscounts = document.querySelectorAll('.yearly-discount');

    const monthlyBtn = document.getElementById('monthlyBtn');
    const yearlyBtn = document.getElementById('yearlyBtn');

    monthlyBtn.addEventListener('click', () => {
        prices.forEach((el, index) => {
            const monthly = parseInt(el.dataset.monthly);
            el.textContent = `$${monthly}/mo`;
            yearlyDiscounts[index].classList.add('hidden');
        });

        monthlyBtn.classList.add('bg-blue-600', 'text-white');
        monthlyBtn.classList.remove('text-blue-600');
        yearlyBtn.classList.remove('bg-blue-600', 'text-white');
        yearlyBtn.classList.add('text-blue-600');
    });

    yearlyBtn.addEventListener('click', () => {
        prices.forEach((el, index) => {
            const monthly = parseInt(el.dataset.monthly);
            const originalYearly = monthly * 12;
            const discountedYearly = Math.round(monthly * 10); // 20% discount

            el.textContent = ``;
            oldPrices[index].textContent = originalYearly;
            newPrices[index].textContent = discountedYearly;
            yearlyDiscounts[index].classList.remove('hidden');
        });

        yearlyBtn.classList.add('bg-blue-600', 'text-white');
        yearlyBtn.classList.remove('text-blue-600');
        monthlyBtn.classList.remove('bg-blue-600', 'text-white');
        monthlyBtn.classList.add('text-blue-600');
    });
</script>
@endsection
