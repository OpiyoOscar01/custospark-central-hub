@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">User Feedback</h1>
            <p class="mt-2 text-sm text-gray-600">View and manage feedback submitted by users</p>
        </div>
    </div>


    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <form action="{{ route('feedback.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="bi bi-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Search feedback..."
                        class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>

            <!-- Rating -->
            <div>
                <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                <select name="rating" id="rating"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">All Ratings</option>
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Stars</option>
                    @endfor
                </select>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">All</option>
                    @foreach (['pending','triaged','in_progress','resolved','responded','closed','rejected'] as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-2">
                <a href="{{ route('feedback.index') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white hover:bg-gray-50">
                    <i class="bi bi-x-circle mr-2"></i> Clear
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm text-white bg-blue-600 hover:bg-blue-700">
                    <i class="bi bi-filter-circle mr-2"></i> Filter
                </button>
             
            </div>
        </form>
    </div>

    <!-- Feedback Table -->
    <div class="bg-white rounded-xl shadow overflow-x-auto border border-gray-200">
     <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-gray-700 text-center">
                <tr>
                    <th class="px-4 py-3 font-medium">#</th>
                    <th class="px-4 py-3 font-medium">User</th>
                    <th class="px-4 py-3 font-medium">Rating</th>
                    <th class="px-4 py-3 font-medium text-left">Message</th>
                    <th class="px-4 py-3 font-medium">Status</th>
                    <th class="px-4 py-3 font-medium">Submitted At</th>
                    <th class="px-4 py-3 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-center">
                @forelse($feedback as $index => $item)
                    <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }} hover:bg-gray-100">
                        <td class="px-4 py-3">{{ $loop->iteration + ($feedback->currentPage() - 1) * $feedback->perPage() }}</td>
                        <td class="px-4 py-3">{{ $item->user->first_name }} {{ $item->user->last_name }}</td>
                        <td class="px-4 py-3">{{ $item->rating }} ★</td>
                        <td class="px-4 py-3 text-left">
                            {{ Str::limit($item->message, 10) }}
                            <a href="{{ route('feedback.show', $item) }}" class="text-blue-600 hover:underline ml-2">View All</a>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                @class([
                                    'bg-gray-200 text-gray-800' => $item->status === 'pending',
                                    'bg-yellow-200 text-yellow-800' => $item->status === 'triaged',
                                    'bg-blue-200 text-blue-800' => $item->status === 'in_progress',
                                    'bg-green-200 text-green-800' => $item->status === 'resolved',
                                    'bg-indigo-200 text-indigo-800' => $item->status === 'responded',
                                    'bg-gray-400 text-white' => $item->status === 'closed',
                                    'bg-red-200 text-red-800' => $item->status === 'rejected',
                                ])">
                                {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $item->created_at->format('d M, Y') }}</td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('feedback.show', $item) }}" class="text-blue-500 hover:text-blue-700" title="View">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                           <a href="{{ route('feedback.edit', $item) }}" class="text-yellow-500 hover:text-yellow-600" title="Edit">
                              <i class="bi bi-pencil-square"></i>
                          </a>

                          <form action="{{ route('feedback.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this feedback?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="text-red-500 hover:text-red-600" title="Delete">
                                  <i class="bi bi-trash"></i>
                              </button>
</form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-6 text-center text-gray-500">No feedback found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $feedback->withQueryString()->links() }}
    </div>
</div>
@endsection
