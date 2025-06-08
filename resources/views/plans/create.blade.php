@extends('layouts.employee')

@section('content')
<div class="py-2 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('plans.index') }}" class="hover:text-gray-700">Plans</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Create Plan</span>
    </nav>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">


                    <i class="bi bi-layers text-blue-600 text-xl"></i>

                </div>
                <h1 class="text-2xl font-bold text-gray-900">Create New Plan</h1>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('plans.store') }}" method="POST" class="space-y-8">
                @csrf

                <!-- Plan Information -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="bi bi-info-circle text-blue-600"></i>

                        Plan Information
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- App -->
                        <div>
                            <label for="app_id" class="block text-sm font-medium text-gray-700 mb-1">Application</label>
                            <select name="app_id" id="app_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>


                                <option value="">-- Select App --</option>
                                @foreach($apps as $app)
                                    <option value="{{ $app->id }}" {{ old('app_id') == $app->id ? 'selected' : '' }}>
                                        {{ $app->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('app_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Plan Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>

                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>


                            @error('slug')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (USD)</label>
                            <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>


                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
            <label for="level" class="block text-sm font-medium text-gray-700 mb-1">Plan Level (Rank)</label>
            <input 
                type="number" 
                name="level" 
                id="level" 
                value="{{ old('level', $plan->level ?? '') }}" 
                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                required 
                min="1"
                placeholder="e.g. 1 for basic, 2 for standard..."
            >

            @error('level')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>


                        <!-- Billing Cycle -->
                        <div>
                            <label for="billing_cycle" class="block text-sm font-medium text-gray-700 mb-1">Billing Cycle</label>
                            <select name="billing_cycle" id="billing_cycle" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>


                                <option value="">-- Select Cycle --</option>
                                <option value="monthly" {{ old('billing_cycle') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="yearly" {{ old('billing_cycle') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                            </select>
                            @error('billing_cycle')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
   <!-- Plan Type Selection -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        <i class="bi bi-cash-coin mr-1 text-gray-500"></i> Select Plan Type <span class="text-red-500">*</span>
    </label>
    <div class="flex items-center space-x-6">
        <!-- Free Plan -->
        <label class="inline-flex items-center">
            <input type="radio" name="plan_type" value="free" {{ old('plan_type') == 'free' ? 'checked' : '' }}
                   class="text-blue-600 border-gray-300 focus:ring-blue-500 plan-type-radio">
            <span class="ml-2 text-sm text-gray-700">Free</span>
        </label>

        <!-- Trial Plan -->
        <label class="inline-flex items-center">
            <input type="radio" name="plan_type" value="trial" {{ old('plan_type') == 'trial' ? 'checked' : '' }}
                   class="text-blue-600 border-gray-300 focus:ring-blue-500 plan-type-radio">
            <span class="ml-2 text-sm text-gray-700">Trial</span>
        </label>

        <!-- Paid Only -->
        <label class="inline-flex items-center">
            <input type="radio" name="plan_type" value="paid" {{ old('plan_type') == 'paid' ? 'checked' : '' }}
                   class="text-blue-600 border-gray-300 focus:ring-blue-500 plan-type-radio">
            <span class="ml-2 text-sm text-gray-700">Paid Only</span>
        </label>
    </div>
    @error('plan_type')
        <p class="text-sm text-red-600 mt-1">
            <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
        </p>
    @enderror
</div>

<!-- Trial Days -->
<div id="trial-days-field" style="display: none;" class="mt-4">
    <label for="trial_days" class="block text-sm font-medium text-gray-700 mb-1">
        <i class="bi bi-clock-history mr-1 text-gray-500"></i> Trial Period (in days) <span class="text-red-500">*</span>
    </label>
    <input id="trial_days" name="trial_days" type="number" min="1" value="{{ old('trial_days') }}"
           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
           placeholder="e.g. 14">
    @error('trial_days')
        <p class="text-sm text-red-600 mt-1">
            <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
        </p>
    @enderror
</div>

<!-- JS to toggle trial days input -->
<script>
    function toggleTrialInput() {
        const trialField = document.getElementById('trial-days-field');
        const selected = document.querySelector('input[name="plan_type"]:checked');
        trialField.style.display = (selected && selected.value === 'trial') ? 'block' : 'none';
    }

    document.querySelectorAll('.plan-type-radio').forEach(radio => {
        radio.addEventListener('change', toggleTrialInput);
    });

    // Initialize on page load
    window.addEventListener('DOMContentLoaded', toggleTrialInput);
</script>


                        <!-- Is Popular -->
                        <div>
                            <label for="is_popular" class="block text-sm font-medium text-gray-700 mb-1">Popular Plan</label>
                            <div class="flex items-center space-x-4 mt-1">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="is_popular" value="1" class="form-radio h-4 w-4 text-blue-500" {{ old('is_popular') == '1' ? 'checked' : '' }}>
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="is_popular" value="0" class="form-radio h-4 w-4 text-blue-500" {{ old('is_popular', '0') == '0' ? 'checked' : '' }}>
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                            @error('is_popular')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="4" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('plans.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <i class="bi bi-x-lg mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <i class="bi bi-check-lg mr-2"></i>
                        Create Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
