@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('apps.index') }}" class="hover:text-gray-700">Apps</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <a href="{{ route('plans.index', $app) }}" class="hover:text-gray-700">Plans</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <a href="{{ route('plans.features.index', $plan) }}" class="hover:text-gray-700">Features</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">View Feature</span>
    </nav>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                    <i class="bi bi-eye text-blue-600 text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">
                    View Feature in <span class="text-blue-500">{{ $app->name }}</span> (Plan: <span class="text-blue-500">{{ $plan->name }}</span>)
                </h1>
            </div>
        </div>

        <!-- Feature Details -->
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Feature Name</h2>
                    <p class="text-lg font-semibold text-gray-900">{{ $feature->name }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Minimum Plan Level.</h2>
                    <p class="text-lg font-semibold text-gray-900">{{ $feature->min_plan_level }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Code</h2>
                    <p class="text-lg font-semibold text-gray-900">{{ $feature->code }}</p>
                </div>
               
                <div class="md:col-span-2">
                    <h2 class="text-sm font-medium text-gray-500">Description</h2>
                    <p class="text-gray-900">{{ $feature->description ?? 'No description provided.' }}</p>
                </div>
            </div>

            <!-- Action Button -->
            <div class="pt-4">
                <a href="{{ route('plans.features.index', $plan) }}" 
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="bi bi-arrow-left mr-2"></i>
                    Back to Features
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
