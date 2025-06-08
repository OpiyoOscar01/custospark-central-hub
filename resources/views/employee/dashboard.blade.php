@extends('layouts.employee')

@section('content')
<div class="py-10 px-6 max-w-7xl mx-auto lg:mb-32">

    <!-- Greeting -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900">
            Welcome to Custospark,
            <span class="text-blue-500">{{ optional(Auth::user())->first_name ?? 'User' }}</span>!
        </h2>
        <p class="text-gray-600">Select an app to get started.</p>
        <p class="text-sm text-gray-500 mt-2">
            One account gives you access to <strong>all Custospark apps</strong>.
            Enjoy your 1-month free trial with full features across the platform!
        </p>
    </div>

    <!-- Search Bar -->
    <div class="text-center mb-10">
        <input
            type="text"
            id="app-search"
            placeholder="Search apps..."
            onkeyup="filterApps()"
            class="w-full max-w-md mx-auto px-5 py-3 rounded-lg bg-gray-50 border border-gray-300 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
    </div>

    <!-- App Cards Grid -->
 <!-- App Cards Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8" id="app-list">
    @forelse ($apps as $app)
        @php
            $freePlan = optional($app->plans)->firstWhere('plan_type', 'free');
            $trialPlan = optional($app->plans)->firstWhere('plan_type', 'trial');
            $paidPlan = optional($app->plans)->firstWhere('plan_type', 'paid');
            $userSub = $subscriptions[$app->id] ?? null;
            $targetPlan = $freePlan ?? $trialPlan ?? $paidPlan;
            $summaryRoute = $targetPlan ? route('subscriptions.summary', ['app' => $app->slug, 'plan' => $targetPlan->id]) : '#';
            $iconUrl = $app->icon_url ? asset($app->icon_url) : asset('images/v8.png');
            $baseUrl = $app->base_url;
        @endphp

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-md hover:shadow-lg transition-shadow flex flex-col items-center text-center">
            <img
                src="{{ $iconUrl }}"
                alt="{{ $app->name ?? 'App Icon' }}"
                class="w-16 h-16 mb-5 rounded-lg shadow-md hover:scale-110 transition-transform"
            />

            <h3 class="text-xl font-semibold text-blue-600 mb-2">{{ ucfirst($app->name ?? 'Unnamed App') }}</h3>
            <p class="text-gray-600 mb-4">
                {{ $app->tagline ?? $app->description ?? 'No description available.' }}
            </p>

            @if ($userSub && optional($userSub->plan)->name)
                <div class="mb-3">
                    <span class="text-gray-900 px-4 py-1 font-semibold text-sm">Current Plan:</span>
                    <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full font-semibold text-sm">
                        {{ ucfirst($userSub->plan->name) }}
                    </span>
                </div>

                <a href="{{ $baseUrl . '/dashboard' }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full font-semibold text-sm shadow transition">
                    Go to App
                </a>
            @else
                @if ($freePlan)
                    <a href="{{ $summaryRoute }}"
                       class="bg-blue-600 text-white px-4 py-1 rounded-full font-semibold text-sm mb-3 hover:brightness-110 transition">
                        Start for Free
                    </a>
                @elseif ($trialPlan)
                    <a href="{{ $summaryRoute }}"
                       class="bg-blue-600 text-white px-4 py-1 rounded-full font-semibold text-sm mb-3 hover:brightness-110 transition">
                        Start Free Trial ({{ $trialPlan->trial_days ?? 'X' }} days)
                    </a>
                @elseif ($paidPlan)
                    <a href="{{ $summaryRoute }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full font-semibold text-sm shadow transition">
                        Subscribe Now
                    </a>
                @else
                    <span class="text-sm text-gray-800 mb-3">No plans available</span>
                @endif
            @endif
        </div>
    @empty
<div class="col-span-full text-center text-gray-500 text-lg py-12">
  <p class="text-3xl font-bold text-blue-500 mb-3">
    Your apps will appear here.
  </p>
  <p class="text-base text-gray-600 mb-2">
    Our Team is currently building powerful tools to help you do more with Custospark.
  </p>
  <p class="text-base text-gray-600 mb-4">
    Stay tuned — exciting things are on the way. If you have any feedback or questions, we’d love to hear from you.
  </p>
<div class="flex justify-center gap-4 mt-4 flex-wrap">
  <a href="{{ route('help.contacts') }}"
     class="inline-block px-5 py-2 bg-blue-500 text-white rounded-md shadow-md hover:bg-blue-700 transition-all duration-200 font-medium">
    <i class="bi bi-chat-dots-fill mr-2"></i>Contact Support
  </a>

  <a href="{{ route('feedback.create') }}"
     class="inline-block px-5 py-2 bg-blue-500 text-white rounded-md shadow-md hover:bg-blue-700 transition-all duration-200 font-medium">
    <i class="bi bi-pencil-square mr-2"></i>Send Feedback
  </a>
</div>

</div>


    @endforelse
</div>

</div>

<!-- JavaScript: Filter Apps -->
<script>
    function filterApps() {
        const searchInput = document.getElementById("app-search").value.toLowerCase();
        const appCards = document.querySelectorAll("#app-list > div");

        appCards.forEach(card => {
            const title = card.querySelector("h3").textContent.toLowerCase();
            card.style.display = title.includes(searchInput) ? "block" : "none";
        });
    }
</script>
@endsection
