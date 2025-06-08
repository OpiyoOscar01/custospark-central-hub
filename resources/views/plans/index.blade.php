@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Plan Management</h1>
            <p class="mt-2 text-sm text-gray-600">Manage subscription plans and related features per application</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('plans.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                <i class="bi bi-plus-lg mr-2"></i>
                Add New Plan
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <form action="{{ route('plans.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- App Filter -->
            <div>
                <label for="app_id" class="block text-sm font-medium text-gray-700 mb-1">App</label>
                <select name="app_id" id="app_id"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">All Apps</option>
                    @foreach($apps as $app)
                        <option value="{{ $app->id }}" {{ request('app_id') == $app->id ? 'selected' : '' }}>
                            {{ $app->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Feature Filter -->
            <div>
                <label for="feature" class="block text-sm font-medium text-gray-700 mb-1">Feature</label>
                <select name="feature" id="feature"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">All Features</option>
                    @foreach($features as $feature)
                        <option value="{{ $feature->id }}" {{ request('feature') == $feature->id ? 'selected' : '' }}>
                            {{ $feature->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Billing Cycle -->
            <div>
                <label for="billing_cycle" class="block text-sm font-medium text-gray-700 mb-1">Billing Cycle</label>
                <select name="billing_cycle" id="billing_cycle"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">All</option>
                    <option value="monthly" {{ request('billing_cycle') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="yearly" {{ request('billing_cycle') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-end space-x-2">
                <a href="{{ route('plans.index') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white hover:bg-gray-50">
                    <i class="bi bi-x-circle mr-2"></i>
                    Clear
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm text-white bg-blue-600 hover:bg-blue-700">
                    <i class="bi bi-filter-circle mr-2"></i>
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Plans Table -->
    <div class="bg-white rounded-xl shadow overflow-x-auto border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-3 font-medium">#</th>
                    <th class="px-4 py-3 font-medium">Plan Name</th>
                    <th class="px-4 py-3 font-medium">Plan Level</th>
                    <th class="px-4 py-3 font-medium">App</th>
                    <th class="px-4 py-3 font-medium">Price(USD)</th>
                    <th class="px-4 py-3 font-medium">Plan Type</th>
                    <th class="px-4 py-3 font-medium">Billing</th>
                    <th class="px-4 py-3 font-medium">Popular</th>
                    <th class="px-4 py-3 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($plans as $plan)
                    <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                        <td class="px-4 py-3">{{ $loop->iteration + ($plans->currentPage() - 1) * $plans->perPage() }}</td>
                        <td class="px-4 py-3">{{ $plan->name }}</td>
                        <td class="px-4 py-3">{{ $plan->level}}</td>
                        <td class="px-4 py-3">{{ $plan->app->name }}</td>
                        <td class="px-4 py-3">{{ number_format($plan->price, 2) }}</td>
                        <td class="px-4 py-3">{{$plan->plan_type}}</td>
                        <td class="px-4 py-3 capitalize">{{ $plan->billing_cycle }}</td>
                        <td class="px-4 py-3">
                            @if($plan->is_popular)
                                <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Yes</span>
                            @else
                                <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">No</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('plans.show', $plan) }}" class="text-blue-500 hover:text-blue-700">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('plans.edit', $plan) }}" class="text-blue-500 hover:text-blue-700">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('plans.features.index', $plan) }}" class="text-green-500 hover:text-green-700" title="Manage Features.">
                                <i class="bi bi-stars"></i>
                            </a>
                            <form action="{{ route('plans.destroy', $plan) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('Are you sure you want to delete this plan?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-6 text-center text-gray-500">No plans found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $plans->withQueryString()->links() }}
    </div>
</div>
@endsection
