@extends('layouts.employee')

@section('content')
<div class="py-2 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('plans.index') }}" class="hover:text-gray-700">Plans</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">{{ $plan->name }}</span>
    </nav>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200 mt-4">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                    <i class="bi bi-layers text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $plan->name }}</h1>
                    <p class="text-sm text-gray-500">{{ $plan->slug }}</p>
                </div>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Plan Information -->
            <div>
                <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                    <i class="bi bi-info-circle text-blue-600"></i>
                    Plan Details
                </h2>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                    <div>
                        <dt class="font-medium">Application</dt>
                        <dd class="mt-1">{{ $plan->app->name ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium">Price (USD)</dt>
                        <dd class="mt-1">${{ number_format($plan->price, 2) }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium">Billing Cycle</dt>
                        <dd class="mt-1 capitalize">{{ $plan->billing_cycle }}</dd>
                    </div>
                  <!-- Plan Type -->
                <div>
                    <dt class="font-medium">Plan Type</dt>
                    <dd class="mt-1 capitalize">{{ $plan->plan_type }}</dd>
                </div>
                <div>
                    <dt class="font-medium">Plan level</dt>
                    <dd class="mt-1 capitalize">{{ $plan->level ?? "Not Provided"}}</dd>
                </div>

                <!-- Trial Days (Only if Trial Plan) -->
                @if ($plan->plan_type === 'trial' && $plan->trial_days)
                    <div>
                        <dt class="font-medium">Trial Period</dt>
                        <dd class="mt-1 text-gray-700">{{ $plan->trial_days }} day{{ $plan->trial_days > 1 ? 's' : '' }}</dd>
                    </div>
@endif

                    <div>
                        <dt class="font-medium">Popular Plan</dt>
                        <dd class="mt-1">
                            @if($plan->is_popular)
                                <span class="text-green-600 font-semibold">Yes</span>
                            @else
                                <span class="text-gray-500">No</span>
                            @endif
                        </dd>
                    </div>
                    <div class="md:col-span-2">
                        <dt class="font-medium">Description</dt>
                        <dd class="mt-1 text-gray-600 whitespace-pre-line">{{ $plan->description }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Actions -->
            <div class="flex justify-end pt-4 border-t border-gray-200">
                <a href="{{ route('plans.edit', $plan->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                    <i class="bi bi-pencil-square mr-2"></i> Edit Plan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
