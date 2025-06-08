@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
        <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
            <a href="{{ route('user.referrals.earnings') }}" class="hover:text-gray-700">
                <span class="text-blue-500">My Referral Earnings</span>
            </a>
            <i class="bi bi-chevron-right text-xs"></i>
            <span class="text-gray-900">My Referral Links</span>
        </nav>


    <!-- Header + Motivation -->
    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                    <i class="bi bi-stars text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">My Referral Links</h1>
                    <p class="text-sm text-gray-500 mt-1">Earn rewards by sharing apps you love. It’s simple, powerful, and rewarding.</p>
                </div>
            </div>
            <div class="bg-green-50 text-green-700 text-sm px-4 py-2 rounded-lg border border-green-200">
                <i class="bi bi-cash-coin mr-1"></i>
                You've earned <span class="font-semibold">${{ number_format($totalReferralEarnings ?? 0, 2) }}</span> so far 🎉
            </div>
        </div>

        <!-- Table -->
        <div class="p-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-gray-700 font-semibold">#</th>
                        <th class="px-4 py-2 text-gray-700 font-semibold">App</th>
                        <th class="px-4 py-2 text-gray-700 font-semibold">Referral URL</th>
                        <th class="px-4 py-2 text-gray-700 font-semibold text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($apps as $index => $app)
                        <tr>
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 font-medium">{{ $app->name }}</td>
                            <td class="px-4 py-2">
                                @if($existingLinks->has($app->id))
                                    <span class="text-sm text-blue-600 break-all" id="referral-url-{{ $app->id }}">
                                        {{ $existingLinks[$app->id]->referral_url }}
                                    </span>
                                @else
                                    <span class="text-gray-500 italic">Not generated</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-center">
                                @if($existingLinks->has($app->id))
                                    <button 
                                        data-url="{{ $existingLinks[$app->id]->referral_url }}"
                                        onclick="copyToClipboard(this)"
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded">
                                        <i class="bi bi-clipboard me-1"></i> Copy Link
                                    </button>
                                    <span class="ml-2 text-green-600 text-sm hidden">Copied!</span>
                                @else
                                    <form method="POST" action="{{ route('user.referrals.generate', ['app' => $app->id]) }}">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded">
                                            <i class="bi bi-plus-circle me-1"></i> Generate Link
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center px-4 py-4 text-gray-500">No apps available to refer yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- CTA Section -->
        <div class="p-6 bg-indigo-50 border-t border-gray-200 rounded-b-xl">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-indigo-900">Referring pays off.</h2>
                    <p class="text-sm text-gray-600">Every successful signup through your link gets you closer to free features, discounts, or even payouts.</p>
                </div>
                <a href="{{ route('user.referrals.earnings') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded hover:bg-indigo-700">
                    <i class="bi bi-graph-up-arrow mr-2"></i> Track Referrals
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(button) {
        const text = button.getAttribute('data-url');
        navigator.clipboard.writeText(text).then(() => {
            const copiedMsg = button.nextElementSibling;
            if (copiedMsg) {
                copiedMsg.classList.remove('hidden');
                setTimeout(() => {
                    copiedMsg.classList.add('hidden');
                }, 2000);
            }
        }).catch((err) => {
            alert('Failed to copy: ' + err);
        });
    }
</script>
@endsection
