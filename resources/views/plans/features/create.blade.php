@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('apps.index') }}" class="hover:text-gray-700">Apps</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <a href="{{ route('plans.index', $app) }}" class="hover:text-gray-700">Plans</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Add Feature</span>
    </nav>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                    <i class="bi bi-stars text-blue-600 text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Add Feature to <span class="text-blue-500">{{ $app->name }}</span> (Plan: <span class="text-blue-500">{{ $plan->name }}</span>)</h1>
            </div>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ route('plans.features.store', $plan) }}" class="space-y-8">
                @csrf

                <!-- Hidden Fields -->
                <input type="hidden" name="app_id" value="{{ $app->id }}">
                <input type="hidden" name="plan_id" value="{{ $plan->id }}">

                <!-- Feature Details Section -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="bi bi-tools text-blue-600"></i>
                        Feature Details
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Feature Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Feature Name</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}" 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Feature Code -->
                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Code</label>
                            <input type="text" 
                                   name="code" 
                                   id="code" 
                                   value="{{ old('code') }}" 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   required>
                            @error('code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                        <label for="min_plan_level" class="block text-sm font-medium text-gray-700 mb-1">Minimum Plan Level</label>
                        <input type="number" 
                            name="min_plan_level" 
                            id="min_plan_level" 
                            value="{{ old('min_plan_level', $feature->min_plan_level ?? 1) }}" 
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            min="1"
                            required>
                        @error('min_plan_level')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                        <!-- Value (Optional) -->
                        <div>
                            <label for="value" class="block text-sm font-medium text-gray-700 mb-1">Value</label>
                            <input type="text" 
                                   name="value" 
                                   id="value" 
                                   required
                                   value="{{ old('value') }}" 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('value')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="4"
                                      class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('plans.show', $plan) }}" 
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <i class="bi bi-x-lg mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <i class="bi bi-check-lg mr-2"></i>
                        Save Feature
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
