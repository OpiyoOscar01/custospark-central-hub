@extends('layouts.employee')

@section('content')
<div class="max-w-7xl mx-auto bg-white p-6 sm:p-8 shadow-lg rounded-lg mt-10 text-gray-800">
    
    <!-- Breadcrumb -->
    <nav class="mb-6 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('general.pricing') }}" class="hover:text-gray-700 flex items-center">
            <i class="bi bi-arrow-left-short text-blue-500 text-lg mr-1"></i>
            <span class="text-blue-600 font-medium">All Plans</span>
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900 font-medium">{{ $app->name }} Plans</span>
    </nav>


    {{-- Flash success message --}}
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded flex items-center">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

   {{-- Settings Controls: Currency & Billing Toggle --}}
<div class="bg-white border border-blue-100 rounded-lg shadow-sm p-6 mb-6 space-y-6">

    {{-- Heading --}}
    <div class="text-center space-y-1">
        <h1 class="text-2xl font-bold text-gray-900">Plans for <span class="text-blue-600">{{ $app->name }}</span></h1>
        <p class="text-sm text-gray-600">{{ $app->description }}</p>
    </div>

    {{-- Controls --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-6">

        {{-- Preferred Currency --}}
        <form action="{{ route('settings.update.currency') }}" method="POST"
              class="flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 w-full sm:w-auto">
            @csrf
            @method('PUT')

            <label for="currency" class="flex items-center text-sm font-medium text-gray-700 space-x-2">
                <i class="bi bi-currency-exchange text-indigo-600 text-lg"></i>
                <span>Preferred currency</span>
            </label>

            <select name="currency" id="currency" onchange="this.form.submit()"
                    class="border border-gray-300 rounded px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white w-full sm:w-auto">
                @foreach(\App\Helpers\CurrencyHelper::getActiveCurrencies() as $c)
                    <option value="{{ $c->code }}" @selected(auth()->user()->preferred_currency === $c->code)>
                        {{ $c->name }} ({{ $c->code }})
                    </option>
                @endforeach
            </select>
        </form>

        {{-- Billing Toggle --}}
        <div class="flex items-center">
            <div class="bg-gray-100 rounded-full overflow-hidden shadow-inner border border-gray-200">
                <button id="monthlyBtn" class="px-4 py-2 text-sm font-semibold bg-blue-600 text-white transition-colors">
                    Monthly
                </button>
                <button id="yearlyBtn" class="px-4 py-2 text-sm font-semibold text-blue-600 hover:bg-blue-50 transition-colors">
                    Yearly
                </button>
            </div>
        </div>

    </div>
</div>




    {{-- Pricing Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
        @forelse($plans as $plan)
            @php
                // Plan state
                $isCurrentPlan       = $currentPlan && $plan->id === $currentPlan->id;
                $isNoPlan            = !$currentPlan;
                $isUpgrade           = $currentPlan && $plan->level > $currentPlan->level;
                $isDowngrade         = $currentPlan && $plan->level < $currentPlan->level;
                $isScheduledDowngrade= $currentSubscription && $currentSubscription->next_plan_id === $plan->id;

                // Routes & labels
                $routeUrl = route('subscriptions.summary', ['app' => $app->slug, 'plan' => $plan->id]);
                if (in_array($plan->plan_type, ['free','trial'])) {
                    $buttonLabel = $plan->plan_type === 'free' ? 'Start for Free' : 'Start Free Trial';
                } else {
                    $buttonLabel = 'Subscribe';
                }

                // Prices
                $usdMonthly   = $plan->price;
                $usdYearly    = $plan->price * 10;
                $userCurr     = auth()->user()->preferred_currency ?? 'USD';
                $convMonthly  = \App\Helpers\CurrencyHelper::convert($usdMonthly, $userCurr);
                $convYearly   = \App\Helpers\CurrencyHelper::convert($usdYearly, $userCurr);

                $fmtUSDMon    = \App\Helpers\CurrencyHelper::format($usdMonthly, 'USD');
                $fmtUSDYr     = \App\Helpers\CurrencyHelper::format($usdYearly, 'USD');
                $fmtConvMon   = \App\Helpers\CurrencyHelper::format($convMonthly, $userCurr);
                $fmtConvYr    = \App\Helpers\CurrencyHelper::format($convYearly, $userCurr);
            @endphp

        @php
            // background variations
            if($plan->is_popular) {
            $bgClass = 'bg-gradient-to-br from-indigo-100 to-indigo-50 border-indigo-400 ring-2 ring-indigo-300';
            } else {
            // use $loop->index to alternate light gray/white
            $bgClass = !$loop->even 
                ? 'bg-bg-50 border border-blue-500 hover:shadow-xl' 
                : 'bg-bg-50 border border-blue-500 hover:shadow-xl';
            }
        @endphp

        <div
            class="relative rounded-xl shadow p-6 flex flex-col justify-between transition {{ $bgClass }}"
            data-usd-monthly="{{ $fmtUSDMon }}"
            data-usd-yearly="{{ $fmtUSDYr }}"
            data-conv-monthly="{{ $fmtConvMon }}"
            data-conv-yearly="{{ $fmtConvYr }}"
        >

                @if($plan->is_popular)
                    <div class="absolute top-0 right-0 bg-blue-400 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
                        <i class="bi bi-star-fill mr-1"></i> Popular
                    </div>
                @endif

                <div>
                    <h2 class="text-xl font-bold mb-2">
                        <i class="bi bi-check-circle-fill text-blue-600"></i> {{ $plan->name }}
                    </h2>

                    {{-- USD Price --}}
                    <p class="plan-price text-3xl font-semibold text-gray-800 mb-1">
                        {{ $fmtUSDMon }}<span class="text-base font-medium period">/Mo</span>
                    </p>

                    {{-- Converted Price --}}
                    @if($userCurr !== 'USD')
                        <p class="converted-price text-sm text-blue-500 mb-4">
                            ≈ {{ $fmtConvMon }} <span class="text-base font-medium period">/Mo</span>
                        </p>
                    @else
                        <div class="mb-4"></div>
                    @endif

                    {{-- Features --}}
                    @if($plan->features->count())
                      <ul class="text-black space-y-1 mb-4">
                        @foreach($plan->features as $feature)
                            <li class="flex items-start space-x-2">
                                <i class="bi bi-check-circle-fill text-blue-600 mt-1"></i>
                                <span>{{ $feature->name }}</span>
                            </li>
                        @endforeach
                    </ul>

                    @else
                        <p class="text-sm text-gray-500 mb-4">No features listed for this plan.</p>
                    @endif

                    <p class="text-sm text-gray-600 mb-4">
                        <i class="bi bi-repeat"></i> {{ ucfirst($plan->billing_cycle) }} billing
                    </p>
                </div>

                <div class="mt-6">
                    @if($isCurrentPlan)
                        <div class="bg-green-100 border border-blue-400 text-blue-700 p-3 rounded text-center">
                            <strong>Current Plan</strong><br>
                            Status: <span class="font-semibold">{{ ucfirst($currentSubscription->status ?? 'active') }}</span>
                        </div>
                    @elseif($isScheduledDowngrade)
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 p-3 rounded text-center space-y-1">
                            <strong>Downgrade Scheduled</strong><br>
                            @if($currentSubscription->next_plan_payment_status === 'paid')
                                <p class="text-sm">Payment Status: <span class="font-semibold">Paid</span></p>
                            @else
                                @if(!in_array($plan->plan_type, ['free','trial']))
                                    <p class="text-sm">Payment Status: <span class="font-semibold">Pending Payment</span></p>
                                @endif
                                <form method="POST" action="{{ route('subscriptions.cancel-downgrade', ['app' => $app->slug]) }}">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-sm rounded shadow transition">
                                        <i class="bi bi-x-circle mr-1"></i> Cancel Downgrade
                                    </button>
                                </form>
                            @endif
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-3">
                            @if($isNoPlan)
                                <a href="{{ $routeUrl }}"
                                   class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded font-medium shadow transition">
                                    <i class="bi bi-play-circle me-1"></i> {{ $buttonLabel }}
                                </a>
                            @elseif($isUpgrade)
                                <a href="{{ $routeUrl }}"
                                   class="block text-center bg-blue-500 hover:bg-blue-600 text-white py-2 rounded font-medium shadow transition">
                                    <i class="bi bi-arrow-up-circle me-1"></i> Upgrade
                                </a>
                            @elseif($isDowngrade)
                                <a href="{{ $routeUrl }}"
                                   class="block text-center bg-gray-600 hover:bg-gray-700 text-white py-2 rounded font-medium shadow transition">
                                    <i class="bi bi-arrow-down-circle me-1"></i> Downgrade
                                </a>
                            @else
                                <a href="{{ $routeUrl }}"
                                   class="block text-center bg-blue-500 hover:bg-blue-600 text-white py-2 rounded font-medium shadow transition">
                                    <i class="bi bi-shuffle me-1"></i> Switch Plan
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <p class="col-span-4 text-center text-gray-600">No plans available for this app.</p>
        @endforelse
    </div>

    {{-- Footer note --}}
    <div class="mt-10 text-center text-sm text-gray-500">
        <i class="bi bi-shield-lock"></i> Secure payments powered by Flutterwave
    </div>
    <div class="mt-1 text-center text-sm text-gray-500">
    <i class="bi bi-lock-fill"></i> Secure cloud infrastructure
    </div>
    <div class="mt-1 text-center text-sm text-gray-500">
    <i class="bi bi-shield"></i> Cancel anytime, no contract
    </div>
        <div class="mt-2 text-center">
        <p><i class="bi bi-chat-right "></i> Need help? <a href="{{ route('help.contacts') }}" class="text-blue-600 font-semibold">Contact support</a></p>
    </div>
</div>

{{-- Billing Toggle Script --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const monthlyBtn = document.getElementById('monthlyBtn'),
          yearlyBtn  = document.getElementById('yearlyBtn'),
          cards      = document.querySelectorAll('[data-usd-monthly]');

    monthlyBtn.addEventListener('click', () => switchBilling('monthly'));
    yearlyBtn.addEventListener('click', () => switchBilling('yearly'));

    // Default to monthly
    switchBilling('monthly');

    function switchBilling(mode) {
        // Toggle button styles
        monthlyBtn.classList.toggle('bg-blue-600', mode==='monthly');
        monthlyBtn.classList.toggle('text-white', mode==='monthly');
        yearlyBtn.classList.toggle('bg-blue-600', mode==='yearly');
        yearlyBtn.classList.toggle('text-white', mode==='yearly');

        cards.forEach(card => {
            // Choose formatted values from data-attributes
            const usdText  = mode==='monthly' ? card.dataset.usdMonthly : card.dataset.usdYearly;
            const convText = mode==='monthly' ? card.dataset.convMonthly : card.dataset.convYearly;

            // Update USD display
            card.querySelector('.plan-price').innerHTML = `${usdText}<span class="text-base font-medium period">/${mode==='monthly'?'mo':'yr'}</span>`;

            // Update converted display
            const convEl = card.querySelector('.converted-price');
            if (convEl) {
                convEl.innerHTML = `≈ ${convText}<span class="text-base font-medium period">/${mode==='monthly'?'mo':'yr'}</span>`;
            }
        });
    }
});
</script>
@endsection
