@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('user.profile.show') }}" class="hover:text-gray-700">   <span class="text-blue-900">{{ $user->first_name }} {{ $user->last_name }}</span>
</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Billing History</span>
    </nav>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="bg-green-100 p-2 rounded-lg border border-blue-200">
                    <i class="bi bi-receipt text-blue-600 text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Billing History</h1>
            </div>
        </div>

        <!-- Billing Table -->
        <div class="p-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-gray-700 font-semibold">#</th>
                        <th class="px-4 py-2 text-gray-700 font-semibold">Date Paid</th>
                        <th class="px-4 py-2 text-gray-700 font-semibold">Amount</th>
                        <th class="px-4 py-2 text-gray-700 font-semibold">Method</th>
                        <th class="px-4 py-2 text-gray-700 font-semibold">Status</th>
                        <th class="px-4 py-2 text-gray-700 font-semibold">Transaction ID</th>
                        <th class="px-4 py-2 text-gray-700 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($payments as $index => $payment)
                        <tr>
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $payment->paid_at ?? '—' }}</td>
                            <td class="px-4 py-2">
                                {{ $payment->currency }} {{ number_format($payment->amount, 2) }}
                                @if($payment->prorated_amount)
                                    <span class="text-xs text-gray-500 block">Prorated: {{ number_format($payment->prorated_amount, 2) }} ({{ $payment->prorated_extra_days }} days)</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ ucfirst($payment->method) }}</td>
                            <td class="px-4 py-2">
                                @php
                                    $statusColor = [
                                        'successful' => 'text-green-600 bg-green-100',
                                        'failed' => 'text-red-600 bg-red-100',
                                        'pending' => 'text-yellow-600 bg-yellow-100'
                                    ];
                                  
                                $convertedPaymentPrice = \App\Helpers\CurrencyHelper::convert($payment->amount, $user->preferred_currency, $payment->currency);   ;   
                                @endphp
                                <span class="px-2 py-1 rounded text-xs font-medium {{ $statusColor[$payment->status] ?? 'text-gray-600 bg-gray-100' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $payment->transaction_id ?? '—' }}</td>
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
                            <td colspan="6" class="text-center px-4 py-4 text-gray-500">No billing records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
