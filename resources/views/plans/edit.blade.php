@extends('layouts.employee')

@section('content')
<div class="py-2 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <nav class="flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('plans.index') }}" class="hover:text-gray-700">Plans</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Edit Plan</span>
    </nav>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                    <i class="bi bi-layers text-blue-600 text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Plan</h1>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('plans.update', $plan->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Plan Info -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="bi bi-info-circle text-blue-600"></i>
                        Plan Information
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- App -->
                        <div>
                            <label for="app_id" class="block text-sm font-medium text-gray-700 mb-1">Application</label>
                            <select name="app_id" id="app_id" class="block w-full rounded-lg border-gray-300 shadow-sm" required>
                                <option value="">-- Select App --</option>
                                @foreach($apps as $app)
                                    <option value="{{ $app->id }}" {{ old('app_id', $plan->app_id) == $app->id ? 'selected' : '' }}>
                                        {{ $app->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('app_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                       <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Plan Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $plan->name) }}"
                            class="block w-full rounded-lg border-gray-300 shadow-sm" required>
                        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Tagline -->
                    <div>
                        <label for="tagline" class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                        <input type="text" name="tagline" id="tagline" value="{{ old('tagline', $plan->tagline) }}"
                            class="block w-full rounded-lg border-gray-300 shadow-sm" placeholder="Short catchy phrase about this plan">
                        @error('tagline') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700 mb-1">Plan Level</label>
                        <input 
                            type="number" 
                            name="level" 
                            id="level" 
                            value="{{ old('level', $plan->level ?? '') }}" 
                            class="block w-full rounded-lg border-gray-300 shadow-sm" 
                            placeholder="e.g. 1 for Basic, 2 for Standard, 3 for Premium" 
                            min="1" 
                            required
                        >
                        @error('level') 
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                                <!-- Plan Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Plan Type</label>
                        <div class="flex items-center space-x-4" id="plan-type-options">
                            @foreach (['free' => 'Free', 'trial' => 'Trial', 'paid' => 'Paid Only'] as $value => $label)
                                <label class="inline-flex items-center">
                                    <input type="radio" name="plan_type" value="{{ $value }}"
                                        class="text-blue-600 border-gray-300 focus:ring-blue-500 plan-type-radio"
                                        {{ old('plan_type', $plan->plan_type) === $value ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('plan_type')
                            <p class="text-sm text-red-600 mt-1">
                                <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Trial Days (conditionally shown) -->
                    <div id="trial-days-wrapper" class="mt-4" style="display: none;">
                        <label for="trial_days" class="block text-sm font-medium text-gray-700 mb-1">Trial Days</label>
                        <input type="number" name="trial_days" id="trial_days"
                            value="{{ old('trial_days', $plan->trial_days) }}"
                            class="block w-full rounded-lg border-gray-300 shadow-sm"
                            placeholder="Number of trial days (e.g. 14)">
                        @error('trial_days')
                            <p class="text-sm text-red-600 mt-1">
                                <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- JavaScript to toggle Trial Days -->
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const radios = document.querySelectorAll('input[name="plan_type"]');
                            const trialWrapper = document.getElementById('trial-days-wrapper');

                            function toggleTrialDays() {
                                const selected = Array.from(radios).find(radio => radio.checked)?.value;
                                trialWrapper.style.display = (selected === 'trial') ? 'block' : 'none';
                            }

                            // Initial check
                            toggleTrialDays();

                            // Add event listener to all radios
                            radios.forEach(radio => {
                                radio.addEventListener('change', toggleTrialDays);
                            });
                        });
                    </script>


                        <!-- Slug -->
                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug', $plan->slug) }}" class="block w-full rounded-lg border-gray-300 shadow-sm" required>
                            @error('slug') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (USD)</label>
                            <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $plan->price) }}" class="block w-full rounded-lg border-gray-300 shadow-sm" required>
                            @error('price') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Billing Cycle -->
                        <div>
                            <label for="billing_cycle" class="block text-sm font-medium text-gray-700 mb-1">Billing Cycle</label>
                            <select name="billing_cycle" id="billing_cycle" class="block w-full rounded-lg border-gray-300 shadow-sm" required>
                                <option value="monthly" {{ old('billing_cycle', $plan->billing_cycle) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="yearly" {{ old('billing_cycle', $plan->billing_cycle) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                            </select>
                            @error('billing_cycle') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Is Popular -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Popular Plan</label>
                            <div class="flex items-center space-x-4 mt-1">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="is_popular" value="1" class="form-radio h-4 w-4" {{ old('is_popular', $plan->is_popular) == 1 ? 'checked' : '' }}>
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="is_popular" value="0" class="form-radio h-4 w-4" {{ old('is_popular', $plan->is_popular) == 0 ? 'checked' : '' }}>
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                            @error('is_popular') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="4" class="block w-full rounded-lg border-gray-300 shadow-sm">{{ old('description', $plan->description) }}</textarea>
                        @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('plans.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">
                        <i class="bi bi-x-lg mr-2"></i> Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                        <i class="bi bi-check-lg mr-2"></i> Update Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
