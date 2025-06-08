@extends('layouts.employee')

@section('title', 'Referral Earnings & History')

@section('content')
<div class="p-6 space-y-8">
    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-4">
        <ol class="list-reset flex">
            <li><a href="{{ route('dashboard') }}" class="text-indigo-600 hover:underline">Dashboard</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-700">Referral Earnings</li>
        </ol>
    </nav>

    {{-- Page Heading --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Referral Earnings & History</h1>
        <p class="text-gray-500 mt-1">Track your earnings, referrals, and payouts in one place.</p>
    </div>

{{-- Summary Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- Total Earned --}}
    <div class="bg-gray-50 p-6 rounded-2xl shadow-sm border border-gray-200">
        <div class="flex items-center justify-between mb-2">
            <p class="text-sm text-gray-500">Total Earned</p>
            <i class="bi bi-cash-coin text-green-600 text-xl"></i>
        </div>
        <p class="text-2xl font-bold text-green-600">${{ number_format($totalEarned, 2) }}</p>
    </div>

    {{-- Total Paid --}}
    <div class="bg-gray-50 p-6 rounded-2xl shadow-sm border border-gray-200">
        <div class="flex items-center justify-between mb-2">
            <p class="text-sm text-gray-500">Total Paid</p>
            <i class="bi bi-wallet text-blue-600 text-xl"></i>
        </div>
        <p class="text-2xl font-bold text-blue-600">${{ number_format($totalPaid, 2) }}</p>
    </div>

    {{-- Total Pending --}}
    <div class="bg-gray-50 p-6 rounded-2xl shadow-sm border border-gray-200">
        <div class="flex items-center justify-between mb-2">
            <p class="text-sm text-gray-500">Pending Amount</p>
            <i class="bi bi-hourglass-split text-yellow-600 text-xl"></i>
        </div>
        <p class="text-2xl font-bold text-yellow-600">${{ number_format($totalPending, 2) }}</p>
    </div>
     {{-- Reward Preference --}}
        <form action="{{ route('user.update-reward-preference') }}" method="POST" class="bg-gray-50 p-6 rounded-2xl shadow-sm border border-gray-200">
            @csrf
            <div class="flex items-center justify-between mb-2">
                <label for="referral_reward_preference" class="text-sm text-gray-500">Reward Preference</label>
                <i class="bi bi-gift text-indigo-600 text-xl"></i>
            </div>
            <div class="flex items-center gap-3 mt-2">
                <select name="referral_reward_preference" id="referral_reward_preference"
                        class="rounded-xl border-gray-300 text-gray-700 text-lg font-semibold capitalize focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="coupon" {{ $user->referral_reward_preference === 'coupon' ? 'selected' : '' }}>Coupon</option>
                    <option value="cash" {{ $user->referral_reward_preference === 'cash' ? 'selected' : '' }}>Cash</option>
                </select>
                <button type="submit" class="text-sm px-3 py-1.5 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700">Save</button>
            </div>
        </form>

        {{-- Referral Tools --}}
        <div class="bg-gray-50 p-6 rounded-2xl shadow-sm border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm text-gray-500">Referral Tools</p>
                <i class="bi bi-link-45deg text-blue-600 text-xl"></i>
            </div>
            <div class="flex flex-col gap-2">
                <a href="{{ route('user.referrals.invite') }}" class="inline-flex items-center text-sm text-indigo-600 hover:underline">
                    <i class="bi bi-list me-1"></i> View All Links
                </a>
                <button onclick="navigator.clipboard.writeText('{{ $referralLinks->first()->referral_url ?? '' }}')" class="inline-flex items-center text-sm text-blue-600 hover:underline">
                    <i class="bi bi-share me-1"></i> Share My Link
                </button>
            </div>
        </div>
</div>



    {{-- Referral History --}}
   {{-- Referral History --}}
<div class="bg-white rounded-2xl shadow mb-8">
    <div class="p-4 border-b font-semibold text-lg text-gray-800 flex items-center gap-2">
        <i class="bi bi-people text-indigo-600 text-xl"></i>
        Referral Conversion History
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm divide-y divide-gray-100">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="text-left p-3">#</th>
                    <th class="text-left p-3">Referred User</th>
                    <th class="text-left p-3">App</th>
                    <th class="text-left p-3">Amount Earned</th>
                    <th class="text-left p-3">Status</th>
                    <th class="text-left p-3">Action</th>
                    <th class="text-left p-3">Rewarded At</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($referrals as $i => $ref)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3 font-medium text-gray-500">{{ $i + 1 }}</td>

                        <td class="p-3 flex items-center gap-2">
                            <i class="bi bi-person-circle text-indigo-500"></i>
                            {{ optional($ref->referredUser)->name ?? 'N/A' }}
                        </td>

                        <td class="p-3">{{ $ref->app->name ?? 'All Apps' }}</td>

                        <td class="p-3 text-green-600 font-semibold">
                            <i class="bi bi-cash-coin mr-1"></i>
                            ${{ number_format($ref->earned_amount, 2) }}
                        </td>

                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs font-semibold inline-flex items-center
                                {{ $ref->status === 'rewarded' ? 'bg-green-100 text-green-700' :
                                    ($ref->status === 'converted' ? 'bg-blue-100 text-blue-700' :
                                    'bg-yellow-100 text-yellow-700') }}">
                                <i class="bi {{
                                    $ref->status === 'rewarded' ? 'bi-award-fill' :
                                    ($ref->status === 'converted' ? 'bi-check2-circle' :
                                    'bi-hourglass-split')
                                }} mr-1"></i>
                                {{ ucfirst($ref->status) }}
                            </span>
                        </td>

                        <td class="p-3">
                            @if ($ref->status === 'pending')
                                <span class="text-yellow-600 text-sm font-medium">
                                    <i class="bi bi-clock mr-1"></i> Awaiting Conversion
                                </span>
                            @elseif ($ref->status === 'converted')
                                <span class="text-blue-600 text-sm font-medium">
                                    <i class="bi bi-check-circle mr-1"></i> Waiting Reward
                                </span>
                            @else
                                <span class="text-green-600 text-sm font-medium">
                                    <i class="bi bi-gift-fill mr-1"></i> Rewarded
                                </span>
                            @endif
                        </td>

                        <td class="p-3">
                            {{ $ref->rewarded_at ? $ref->rewarded_at->diffForHumans() : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center p-4 text-gray-400">
                            <i class="bi bi-emoji-frown mr-1"></i> No referrals yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>



    {{-- Payout History --}}
  <div class="bg-white rounded-2xl shadow">
    <div class="p-4 border-b font-semibold text-lg text-gray-800 flex items-center gap-2">
        <i class="bi bi-wallet2 text-indigo-600 text-xl"></i>
        Cash Payout History
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm divide-y divide-gray-100">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="text-left p-3">#</th>
                    <th class="text-left p-3">Amount</th>
                    <th class="text-left p-3">Currency</th>
                    <th class="text-left p-3">Method</th>
                    <th class="text-left p-3">Status</th>
                    <th class="text-left p-3">Action</th>
                    <th class="text-left p-3">Paid At</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($cashPayouts as $i => $payout)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3 font-medium text-gray-500">{{ $i + 1 }}</td>

                        <td class="p-3 text-green-600 font-semibold">
                            <i class="bi bi-currency-dollar mr-1"></i>
                            ${{ number_format($payout->amount, 2) }}
                        </td>

                        <td class="p-3">{{ $payout->currency }}</td>

                        <td class="p-3 capitalize">
                            <i class="bi bi-bank2 mr-1 text-indigo-500"></i>
                            {{ $payout->payment_method ?? 'N/A' }}
                        </td>

                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs font-semibold inline-flex items-center
                                {{ $payout->status === 'paid' ? 'bg-green-100 text-green-700' :
                                    ($payout->status === 'approved' ? 'bg-yellow-100 text-yellow-700' :
                                    'bg-red-100 text-red-700') }}">
                                <i class="bi {{ $payout->status === 'paid' ? 'bi-check-circle-fill' :
                                    ($payout->status === 'approved' ? 'bi-shield-check' :
                                    'bi-hourglass-split') }} mr-1"></i>
                                {{ ucfirst($payout->status) }}
                            </span>
                        </td>

                        <td class="p-3">
                            @if ($payout->status === 'pending')
                                <span class="text-red-400 text-sm font-medium">
                                    <i class="bi bi-clock mr-1"></i> Awaiting Disbursement
                                </span>
                            @elseif ($payout->status === 'approved')
                                <span class="text-yellow-600 text-sm font-medium">
                                    <i class="bi bi-calendar-check mr-1"></i> Waiting Disbursement
                                </span>
                            @else
                                <span class="text-green-600 text-sm font-medium">
                                    <i class="bi bi-cash-stack mr-1"></i> Paid
                                </span>
                            @endif
                        </td>

                        <td class="p-3">
                            {{ $payout->paid_at ? $payout->paid_at->diffForHumans() : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center p-4 text-gray-400">
                            <i class="bi bi-hourglass-split mr-1"></i> No payouts yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4 border-t bg-gray-50 text-sm text-gray-500 flex items-center gap-2">
        <i class="bi bi-info-circle text-blue-500"></i>
        App cashouts are processed on the <strong class="text-gray-800">1st of every new month</strong>.
    </div>
</div>



</div>
@endsection
