@extends('layouts.employee')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-4" aria-label="Breadcrumb">
        <ol class="list-reset flex">
            <li>
                <a href="{{ route('dashboard') }}" class="hover:underline text-blue-600">Dashboard</a>
                <span class="mx-2">/</span>
            </li>
            <li>
                <a href="{{ route('plans.index') }}" class="hover:underline text-blue-600">Plans</a>
                <span class="mx-2">/</span>
            </li>
            <li class="text-gray-700 font-medium">Plan Features</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between mb-6">
       <div>
    <h2 class="text-3xl font-bold text-gray-900">Plan Features</h2>
      <p class="text-sm text-gray-600 mt-1">
          Manage features for 
          <span class="font-medium text-blue-500">{{ $app->name }}</span>'s 
          <span class="font-medium text-indigo-500">{{ $plan->name }}</span> plan
      </p>


</div>

        <a href="{{ route('plans.features.create', $plan) }}"
           class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 shadow-sm">
            <i class="bi bi-plus-lg mr-2"></i> Add New Feature
        </a>
    </div>

    <!-- Search -->
    <div class="bg-white border border-gray-200 rounded-xl p-4 mb-6 shadow-sm">
        <form action="{{ route('plans.features.index', $plan) }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search by Name or Code</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                       placeholder="e.g. storage, STG100">
            </div>
            <div class="flex items-end space-x-2">
                <a href="{{ route('plans.features.index', $plan) }}"
                   class="inline-flex items-center px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm">
                    <i class="bi bi-x-circle mr-2"></i> Clear
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                    <i class="bi bi-search mr-2"></i> Search
                </button>
            </div>
        </form>
    </div>

    <!-- Features Table -->
    <div class="bg-white shadow rounded-xl overflow-x-auto border border-gray-200">
        <table class="min-w-full table-auto text-sm divide-y divide-gray-200">
            <thead class="bg-gray-50 text-gray-700 text-left">
                <tr>
                    <th class="px-4 py-3 font-medium">#</th>
                    <th class="px-4 py-3 font-medium">Feature</th>
                    <th class="px-4 py-3 font-medium">Code</th>
                    <th class="px-4 py-3 font-medium">Description</th>
                    <th class="px-4 py-3 font-medium">Value</th>
                    <th class="px-4 py-3 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($attachedFeatures as $feature)
                    <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                        <td class="px-4 py-3">{{ $loop->iteration + ($attachedFeatures->currentPage() - 1) * $attachedFeatures->perPage() }}</td>
                        <td class="px-4 py-3">{{ $feature->name }}</td>
                        <td class="px-4 py-3">{{ $feature->code }}</td>
                        <td class="px-4 py-3">{{ $feature->description }}</td>
                        <td class="px-4 py-3">{{ $feature->pivot->value }}</td>
                        <td class="px-4 py-3 space-x-2">
                            <a title="edit" href="{{ route('plans.features.edit', [$plan->id, $feature->id]) }}" class="text-blue-500 hover:text-blue-700">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a title="view" href="{{ route('plans.features.show', [$plan->id, $feature->id]) }}" class="text-blue-500 hover:text-blue-700">
                                <i class="bi bi-eye"></i>
                            </a>
                          <div class="inline-flex space-x-2">

    <!-- Delete Feature -->
    <form method="POST" action="{{ route('plans.features.destroy', [$plan,$feature]) }}"
          onsubmit="return confirm('Delete this feature permanently? This cannot be undone.');"
          class="inline-block">
        @csrf
        @method('DELETE')
        <button type="submit" 
                title="Delete Feature" 
                class="text-red-500 hover:text-red-700" 
                aria-label="Delete Feature">
            <i class="bi bi-trash"></i>
        </button>
    </form>

</div>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">No features attached to this plan yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
           @if ($attachedFeatures->hasPages())
        <div class="p-4 border-t border-gray-200 bg-gray-50">
            {{ $attachedFeatures->links('vendor.pagination.tailwind') }}
        </div>
    @endif
    </div>
</div>
@endsection
