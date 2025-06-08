@extends('layouts.employee')

@php use Carbon\Carbon; @endphp

@section('content')
<div class="py-2 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <h1 class="text-xl font-bold text-gray-800 mb-4">Your Subscriptions</h1>

    @if ($subscriptions->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500 border border-gray-200">
            <i class="bi bi-info-circle text-3xl text-blue-500 mb-2"></i>
            <p>No subscriptions found.</p>
        </div>
    @else
        @foreach ($subscriptions as $subscription)
            @php
                $trialEndsAt = $subscription->trial_ends_at ? Carbon::parse($subscription->trial_ends_at) : null;
                $createdAt = Carbon::parse($subscription->created_at);
                $now = Carbon::now();
                $totalTrialDays = $trialEndsAt ? $createdAt->diffInDays($trialEndsAt) : 0;
                $daysLeft = ($trialEndsAt && $now->lt($trialEndsAt)) ? round($now->diffInDays($trialEndsAt), 0) : 0;

                $isFreePlan = $subscription->plan->plan_type ==='free';
                $isTrialActive = $daysLeft > 0 && $subscription->plan->plan_type === 'trial';
                $showUpgrade = $isFreePlan || $isTrialActive;
            @endphp

            <div class="bg-white shadow-lg rounded-xl border border-gray-200 mb-6">
                <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">{{ $subscription->plan->name }}</h2>
                        <p class="text-sm text-gray-500"><i class="bi bi-box"></i> {{ $subscription->plan->app->name ?? 'N/A' }}</p>
                    </div>
                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full flex items-center">
                        <i class="bi bi-check-circle me-1"></i> {{ ucfirst($subscription->status) }}
                    </span>
                </div>

                <div class="p-6 space-y-4 text-sm text-gray-700">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><strong><i class="bi bi-tag"></i> Plan Type:</strong> {{ ucfirst($subscription->plan->plan_type) }}</div>
                        <div><strong><i class="bi bi-repeat"></i> Billing Cycle:</strong> {{ ucfirst($subscription->plan->billing_cycle) }}</div>
                        <div><strong><i class="bi bi-currency-dollar"></i> Price:</strong> ${{ number_format($subscription->plan->price, 2) }}</div>
                        <div><strong><i class="bi bi-calendar-check"></i> Subscribed At:</strong> {{ $subscription->created_at->format('M d, Y') }}</div>

                        @if($subscription->expires_at)
                            <div><strong><i class="bi bi-calendar-x"></i> Expires At:</strong> {{ $subscription->expires_at->format('M d, Y') }}</div>
                        @endif

                        @if($trialEndsAt)
                            <div>
                                <strong><i class="bi bi-hourglass-split"></i> Trial Ends:</strong> {{ $trialEndsAt->format('M d, Y') }}<br>
                                <span class="text-sm text-gray-600">
                                    Total Trial: {{ $totalTrialDays }} {{ Str::plural('day', $totalTrialDays) }} |
                                    @if ($daysLeft > 0)
                                        Days Left: {{ $daysLeft }} {{ Str::plural('day', $daysLeft) }}
                                    @else
                                        Trial Expired
                                    @endif
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Plan Features --}}
                    <div class="mt-4">
                        <h3 class="font-semibold text-gray-800 mb-2">
                            <i class="bi bi-list-check me-1"></i> Plan Features
                        </h3>
                        @if ($subscription->plan->features && count($subscription->plan->features) > 0)
                            <ul class="list-disc list-inside text-gray-700">
                                @foreach ($subscription->plan->features as $feature)
                                    <li>{{ $feature->pivot->value ?? $feature->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500"><i class="bi bi-slash-circle"></i> No features listed.</p>
                        @endif
                    </div>

                    {{-- Payments --}}
                    <div class="mt-4">
                        <h3 class="font-semibold text-gray-800 mb-2">
                            <i class="bi bi-credit-card me-1"></i> Payments
                        </h3>
                        @if ($subscription->payments->isNotEmpty())
                            <ul class="divide-y divide-gray-200 text-sm">
                                @foreach ($subscription->payments as $payment)
                                    <li class="py-2 flex justify-between">
                                        <span>#{{ $payment->id }} - ${{ number_format($payment->amount, 2) }}</span>
                                        <span class="text-gray-500">{{ $payment->created_at->format('M d, Y') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500"><i class="bi bi-exclamation-circle"></i> No payment records found.</p>
                        @endif
                    </div>
                </div>

                @if ($showUpgrade)
                    <div class="p-6 border-t border-gray-200 text-right">
                        <a href="#" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded hover:bg-indigo-700 transition">
                            <i class="bi bi-arrow-up-circle me-2"></i> Upgrade Now
                        </a>
                    </div>
                @endif
            </div>
        @endforeach
    @endif
</div>
@endsection
