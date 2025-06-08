@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('user.profile.show') }}" class="hover:text-gray-700">
            <span class="text-blue-900">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">My Coupons</span>
    </nav>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 p-2 rounded-lg border border-blue-300">
                    <i class="bi bi-ticket-perforated text-blue-600 text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">My Coupons</h1>
            </div>

            <!-- Exclusive Coupons Banner -->
            <div class="px-6 py-4 bg-green-50 text-green-800 text-sm rounded-b-lg border-t border-green-100 mt-4">
                🎁 <strong>Your exclusive coupons are here!</strong> Use them before they expire — these are your rewards for being awesome!
            </div>
        </div>

        <!-- Stats -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center text-sm">
                <div class="bg-white border border-gray-200 rounded-lg py-3 shadow-sm">
                    <div class="text-gray-500">Total Assigned</div>
                    <div class="text-xl font-semibold text-gray-900">{{ $stats['total'] }}</div>
                </div>
                <div class="bg-white border border-green-200 rounded-lg py-3 shadow-sm">
                    <div class="text-green-600">Active</div>
                    <div class="text-xl font-semibold text-green-700">{{ $stats['active'] }}</div>
                </div>
                <div class="bg-white border border-yellow-200 rounded-lg py-3 shadow-sm">
                    <div class="text-yellow-600">Used Up</div>
                    <div class="text-xl font-semibold text-yellow-700">{{ $stats['used_up'] }}</div>
                </div>
                <div class="bg-white border border-red-200 rounded-lg py-3 shadow-sm">
                    <div class="text-red-600">Expired</div>
                    <div class="text-xl font-semibold text-red-700">{{ $stats['expired'] }}</div>
                </div>
            </div>
        </div>

        <!-- Note Above Table -->
        <div class="px-6 pt-6 text-sm text-gray-600">
            <p class="mb-2">
                <strong>Note:</strong> Most users miss out on savings by forgetting to apply coupons. Don't be that person.
            </p>
            <p class="text-red-600 italic">
                {{ $stats['expired'] }} coupon(s) already expired — use your active ones now before they do too.
            </p>
        </div>

        <!-- Coupon Table -->
        <div class="p-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-gray-700 font-semibold">#</th>
                        <th class="px-4 py-2 text-gray-700 font-semibold">Code</th>
                        <th class="px-4 py-2 text-gray-700 font-semibold">App</th>
                        <th class="px-4 py-2 text-gray-700 font-semibold">Type</th>
                        <th class="px-4 py-2 text-gray-700 font-semibold">Value</th>
                        <th class="px-4 py-2 text-gray-700 font-semibold">Usage</th>
                        <th class="px-4 py-2 text-gray-700 font-semibold">Validity</th>
                        <th class="px-4 py-2 text-gray-700 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($coupons as $index => $coupon)
                        @php
                            $now = now();
                            $daysLeft = $coupon->expires_at ? $coupon->expires_at->diffInDays($now, false) : null;
                            $statusLabel = $coupon->is_active ? 'Active' : ($coupon->is_expired ? 'Expired' : 'Inactive');
                            $statusColor = $coupon->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500';
                        @endphp
                        <tr>
                            <td class="px-4 py-2 align-middle">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 font-mono text-sm text-blue-800 align-middle">{{ $coupon->code }}</td>
                            <td class="px-4 py-2 align-middle">{{ $coupon->app->name ?? '—' }}</td>
                            <td class="px-4 py-2 capitalize align-middle">{{ str_replace('_', ' ', $coupon->type) }}</td>
                            <td class="px-4 py-2 align-middle">
                                @if($coupon->type === 'percentage')
                                    {{ $coupon->value }}%
                                @elseif($coupon->type === 'fixed')
                                    ${{ number_format($coupon->value, 2) }}
                                @elseif($coupon->type === 'free_trial')
                                    <span class="text-sm text-indigo-500">Free Trial</span>
                                @else
                                    Custom
                                @endif
                            </td>
                            <td class="px-4 py-2 align-middle">
                                {{ $coupon->used }} / {{ $coupon->max_per_user ?? '∞' }}
                            </td>
                            <td class="px-4 py-2 text-sm align-middle">
                                @if($coupon->starts_at)
                                    <span class="block text-gray-600">From: {{ $coupon->starts_at->format('Y-m-d') }}</span>
                                @endif

                                @if($coupon->expires_at)
                                    <span class="block text-gray-600">To: {{ $coupon->expires_at->format('Y-m-d') }}</span>
                                @else
                                    <span class="block text-gray-400">No expiry</span>
                                @endif

                                @if($coupon->expires_at && $daysLeft <= 3 && $coupon->is_active)
                                    <div class="text-red-500 text-xs mt-1">
                                        <i class="bi bi-clock-history"></i>Expires {{ $coupon->expires_at->diffForHumans() }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-2 align-middle">
                                <span class="px-2 py-1 text-xs rounded {{ $statusColor }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center px-4 py-4 text-gray-500">
                                You don't have any coupons assigned.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $coupons->links() }}
            </div>
        </div>

        <!-- Smart Saver Tip Below Table -->
        <div class="px-6 pb-6 text-sm text-gray-600">
            <p class="text-blue-600">
                <i class="bi bi-lightbulb-fill"></i>Smart Saver Tip: Share your unused coupons with a teammate or friend before they expire!
            </p>
        </div>
    </div>
</div>
@endsection
