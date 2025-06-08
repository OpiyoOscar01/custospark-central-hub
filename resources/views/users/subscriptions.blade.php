@extends('layouts.employee')

@php
    use Carbon\Carbon;
    use App\Helpers\CurrencyHelper;

    $userCurrency = $user->preferred_currency ?? 'USD';

    function safeFormatDate($date, $format = 'M d, Y') {
        if (!$date) return '—';
        try {
            return Carbon::parse($date)->format($format);
        } catch (\Exception $e) {
            return '—';
        }
    }
@endphp

@section('title', 'Subscriptions Overview')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-8">

    {{-- Page Title --}}
    <div class="border-b pb-4">
        <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
            <i class="bi bi-person-circle text-indigo-600"></i>
            {{ trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) }} – Subscriptions Overview
        </h1>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white border rounded-lg shadow p-5">
            <div class="text-sm text-gray-500 mb-1 flex items-center gap-1">
                <i class="bi bi-layers"></i> Total Subscriptions
            </div>
            <div class="text-2xl font-bold text-gray-800">{{ $stats['total_subscriptions'] ?? 0 }}</div>
        </div>
        <div class="bg-white border rounded-lg shadow p-5">
            <div class="text-sm text-gray-500 mb-1 flex items-center gap-1">
                <i class="bi bi-check-circle text-green-500"></i> Active
            </div>
            <div class="text-2xl font-bold text-green-600">{{ $stats['active_subscriptions'] ?? 0 }}</div>
        </div>
        <div class="bg-white border rounded-lg shadow p-5">
            <div class="text-sm text-gray-500 mb-1 flex items-center gap-1">
                <i class="bi bi-hourglass-split text-yellow-500"></i> Trial
            </div>
            <div class="text-2xl font-bold text-yellow-500">{{ $stats['trial_subscriptions'] ?? 0 }}</div>
        </div>
        <div class="bg-white border rounded-lg shadow p-5">
            <div class="text-sm text-gray-500 mb-1 flex items-center gap-1">
                <i class="bi bi-currency-exchange text-blue-500"></i> Total Spent
            </div>
            <div class="text-2xl font-bold text-blue-600">
                {!! CurrencyHelper::format(
                    CurrencyHelper::convert($stats['total_spent'] ?? 0, $userCurrency, 'USD'),
                    $userCurrency
                ) !!}
            </div>
        </div>
    </div>

    {{-- Subscriptions Table --}}
    <div class="bg-white border rounded-lg shadow overflow-x-auto">
       <table class="min-w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
    <thead class="bg-gray-100 text-gray-700 font-semibold">
        <tr>
            <th class="px-4 py-3">#</th>
            <th class="px-4 py-3">
                <i class="bi bi-grid-1x2 me-1"></i> App
            </th>
            <th class="px-4 py-3">
                <i class="bi bi-tag me-1"></i> Plan
            </th>
            <th class="px-4 py-3">
                <i class="bi bi-info-circle me-1"></i> Status
            </th>
            <th class="px-4 py-3">
                <i class="bi bi-hourglass me-1"></i> Trial Ends
            </th>
            <th class="px-4 py-3">
                <i class="bi bi-calendar-x me-1"></i> Ends At
            </th>
            <th class="px-4 py-3">
                <i class="bi bi-arrow-repeat me-1"></i> Renews At
            </th>
            <th class="px-4 py-3">
                <i class="bi bi-gear me-1"></i> Actions
            </th>
        </tr>
    </thead>

    <tbody class="divide-y divide-gray-200 bg-white">
        @forelse ($subscriptions as $index => $sub)
            <tr>
                <td class="px-4 py-3">{{ $index + 1 }}</td>
                <td class="px-4 py-3">{{ $sub->app->name ?? '—' }}</td>
                <td class="px-4 py-3">{{ $sub->plan->name ?? '—' }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded text-xs font-medium
                        @class([
                            'bg-green-100 text-green-700' => ($sub->status ?? '') === 'active',
                            'bg-yellow-100 text-yellow-700' => ($sub->status ?? '') === 'trial',
                            'bg-red-100 text-red-700' => ($sub->status ?? '') === 'canceled',
                            'bg-orange-100 text-orange-700' => ($sub->status ?? '') === 'grace',
                            'bg-gray-100 text-gray-600' => !in_array($sub->status ?? '', ['active', 'trial', 'canceled', 'grace']),
                        ])
                    ">
                        {{ ucfirst($sub->status ?? 'Unknown') }}
                    </span>
                </td>
                <td class="px-4 py-3 text-center">{{ safeFormatDate($sub->trial_ends_at) }}</td>
                <td class="px-4 py-3 text-center">{{ safeFormatDate($sub->ends_at) }}</td>
                <td class="px-4 py-3 text-center">{{ safeFormatDate($sub->renews_at) }}</td>
                <td class="px-4 py-3 text-center">
                    <a href="{{ route('dashboard.pricing.app', ['app' => $sub->app->id]) }}"
                       class="inline-block px-3 py-1 text-xs font-medium text-white bg-blue-500 border border-blue-600 rounded hover:bg-blue-600">
                        Manage
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="px-4 py-4 text-center text-gray-500">
                    No subscriptions found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

    </div>

    {{-- Detailed Subscription Cards --}}
    @foreach ($subscriptions as $subscription)
        @php
            $trialEndsAt = $subscription->trial_ends_at ? Carbon::parse($subscription->trial_ends_at) : null;
            $createdAt = $subscription->created_at ? Carbon::parse($subscription->created_at) : null;
            $now = Carbon::now();

            $totalTrialDays = ($trialEndsAt && $createdAt) ? $createdAt->diffInDays($trialEndsAt) : 0;
            $daysLeft = ($trialEndsAt && $now->lt($trialEndsAt)) ? $now->diffInDays($trialEndsAt) : 0;

            $plan = $subscription->plan;
            $planType = $plan->plan_type ?? 'unknown';
            $isFreePlan = $planType === 'free';
            $isTrialActive = $daysLeft > 0 && $planType === 'trial';
            $showUpgrade = $isFreePlan || $isTrialActive;

            $convertedPrice = $plan ? CurrencyHelper::convert($plan->price ?? 0, $userCurrency, 'USD') : 0;
            $formattedPrice = CurrencyHelper::format($convertedPrice, $userCurrency);

            $planAppName = $plan->app->name ?? 'N/A';
            $billingCycle = ucfirst($plan->billing_cycle ?? 'N/A');
        @endphp

        <div class="bg-white border rounded-xl shadow-md">
            <div class="p-5 border-b flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">{{ $plan->name ?? 'Unknown Plan' }}</h2>
                    <p class="text-sm text-gray-500 flex items-center gap-1">
                        <i class="bi bi-box-seam"></i> {{ $planAppName }}
                    </p>
                </div>
                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full flex items-center gap-1">
                    <i class="bi bi-check-circle"></i> {{ ucfirst($subscription->status ?? 'unknown') }}
                </span>
            </div>

            <div class="p-5 space-y-4 text-sm text-gray-700">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div><strong><i class="bi bi-tag me-1"></i> Type:</strong> {{ ucfirst($planType) }}</div>
                    <div><strong><i class="bi bi-repeat me-1"></i> Billing:</strong> {{ $billingCycle }}</div>
                    <div><strong><i class="bi bi-cash-stack me-1"></i> Price:</strong> {!! $formattedPrice !!}</div>
                    <div><strong><i class="bi bi-calendar-plus me-1"></i> Subscribed:</strong> {{ safeFormatDate($subscription->created_at) }}</div>
                    @if ($subscription->expires_at)
                        <div><strong><i class="bi bi-calendar-x me-1"></i> Expires:</strong> {{ safeFormatDate($subscription->expires_at) }}</div>
                    @endif
                    @if ($trialEndsAt)
                        <div>
                            <strong><i class="bi bi-hourglass-split me-1"></i> Trial Ends:</strong> {{ $trialEndsAt->format('M d, Y') }}<br>
                            <span class="text-gray-500 text-xs">
                                Total Trial: {{ $totalTrialDays }} days |
                                @if ($daysLeft > 0)
                                    {{ $daysLeft }} day(s) left
                                @else
                                    Trial Expired
                                @endif
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            @if ($showUpgrade)
                <div class="p-5 border-t">
                    <a href="{{route('dashboard.pricing.app', ['app' => $subscription->app->id])}}" class="inline-block px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow">
                        Upgrade Plan
                    </a>
                </div>
            @endif
        </div>
    @endforeach

    {{-- Payments History --}}
    <div class="bg-white border rounded-lg shadow p-5">
    <h3 class="text-xl font-semibold mb-4 flex items-center gap-2">
        <i class="bi bi-currency-dollar"></i> Payments History
    </h3>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left divide-y divide-gray-200">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Transaction ID</th>
                    <th class="px-4 py-2">App</th>
                    <th class="px-4 py-2">Plan</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Amount</th>
                    <th class="px-4 py-2">Paid At</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($user->payments as $idx => $payment)
                                @php
                        $convertedPaymentPrice = \App\Helpers\CurrencyHelper::convert($payment->amount, $user->preferred_currency, $payment->currency);   
                    @endphp
                    <tr>
                        <td class="px-4 py-2">{{ $idx + 1 }}</td>
                        <td class="px-4 py-2 font-mono text-indigo-700">
                            {{ $payment->transaction_id ?? '—' }}
                        </td>
                        <td class="px-4 py-2">{{ $payment->subscription->app->name ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $payment->subscription->plan->name ?? '—' }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-xs font-medium
                                @class([
                                    'bg-green-100 text-green-700' => ($payment->status ?? '') === 'success',
                                    'bg-red-100 text-red-700' => ($payment->status ?? '') === 'failed',
                                    'bg-yellow-100 text-yellow-700' => ($payment->status ?? '') === 'pending',
                                    'bg-gray-100 text-gray-600' => !in_array($payment->status ?? '', ['success', 'failed', 'pending']),
                                ])
                            ">
                                {{ ucfirst($payment->status ?? 'unknown') }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            {{ $payment->currency }} {{ number_format($payment->amount, 2) }}
                        </td>
                       <td class="px-4 py-2">{{ safeFormatDate($payment->paid_at) }}</td>
                       <td class="px-4 py-2">
    @if($payment->status === 'pending' || $payment->status === 'failed')
        <div class="flex items-center space-x-2">
            <form action="{{ route('payment.initiate', ['app' => $payment->subscription->app->id, 'plan' => $payment->subscription->plan->id]) }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="finalAmount" value="{{ $convertedPaymentPrice }}">
                <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                <input type="hidden" name="payment_currency" value="{{ $payment->currency }}">

                <button type="submit"
                    class="inline-block px-2 py-0.5 text-xs font-medium text-white border rounded
                    {{ $payment->status === 'pending' ? 'bg-yellow-500 hover:bg-yellow-600 border-yellow-600' : 'bg-red-500 hover:bg-red-600 border-red-600' }}">
                    {{ $payment->status === 'pending' ? 'Complete Payment' : 'Retry Payment' }}
                </button>
            </form>

            <!-- Cancel/Delete Button -->
            <form action="{{ route('payment.cancel', $payment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this payment?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-block px-2 py-0.5 text-xs font-medium text-white bg-gray-500 hover:bg-gray-600 border border-gray-600 rounded">
                    Cancel
                </button>
            </form>
        </div>
    @else
        <span class="text-gray-400 text-xs">No Action Required.</span>
    @endif
</td>



                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-4 text-center text-gray-500">No payments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


</div>
@endsection
