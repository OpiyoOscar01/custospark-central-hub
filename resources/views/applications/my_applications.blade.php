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
            <li class="text-gray-700 font-medium">My Applications</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">My Job Applications</h2>
            <p class="text-sm text-gray-600 mt-1">
                View and manage your submitted job applications.
            </p>
        </div>
    </div>

    <!-- Search -->
    {{-- <div class="bg-white border border-gray-200 rounded-xl p-4 mb-6 shadow-sm">
        <form action="{{ route('applications.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search by Job Title</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                       placeholder="e.g. Software Developer">
            </div>
            <div class="flex items-end space-x-2">
                <a href="{{ route('applications.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm">
                    <i class="bi bi-x-circle mr-2"></i> Clear
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                    <i class="bi bi-search mr-2"></i> Search
                </button>
            </div>
        </form>
    </div> --}}

    <!-- Applications Table -->
    <div class="bg-white shadow rounded-xl overflow-x-auto border border-gray-200">
        <table class="min-w-full table-auto text-sm divide-y divide-gray-200">
            <thead class="bg-gray-50 text-gray-700 text-left">
                <tr>
                    <th class="px-4 py-3 font-medium">#</th>
                    <th class="px-4 py-3 font-medium">Job Title</th>
                    <th class="px-4 py-3 font-medium">Status</th>
                    <th class="px-4 py-3 font-medium">Submitted</th>
                    <th class="px-4 py-3 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($applications as $application)
                    <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                        <td class="px-4 py-3">{{ $loop->iteration + ($applications->currentPage() - 1) * $applications->perPage() }}</td>
                        <td class="px-4 py-3">{{ $application->job->title ?? '—' }}</td>
                        <td class="px-4 py-3">
                        @php
                            $status = $application->status;
                            $statusMap = [
                                'pending' => ['color' => 'bg-gray-100 text-gray-800', 'icon' => 'bi-clock'],
                                'reviewing' => ['color' => 'bg-blue-100 text-blue-800', 'icon' => 'bi-search'],
                                'shortlisted' => ['color' => 'bg-yellow-100 text-yellow-800', 'icon' => 'bi-list-check'],
                                'interview_scheduled' => ['color' => 'bg-purple-100 text-purple-800', 'icon' => 'bi-calendar-event'],
                                'interviewed' => ['color' => 'bg-indigo-100 text-indigo-800', 'icon' => 'bi-person-lines-fill'],
                                'offered' => ['color' => 'bg-teal-100 text-teal-800', 'icon' => 'bi-hand-thumbs-up'],
                                'hired' => ['color' => 'bg-green-100 text-green-800', 'icon' => 'bi-check-circle'],
                                'rejected' => ['color' => 'bg-red-100 text-red-800', 'icon' => 'bi-x-circle'],
                            ];
                        @endphp

                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusMap[$status]['color'] }}">
                            <i class="bi {{ $statusMap[$status]['icon'] }}"></i>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </span>
                    </td>

                        <td class="px-4 py-3">{{ $application->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('user.application.specific.show', $application) }}"
                               title="View" class="text-blue-600 hover:text-blue-800">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if($application->status === 'pending')
                                <a href="{{ route('user.application.edit', $application) }}"
                                   title="Edit" class="text-indigo-600 hover:text-indigo-800">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('user.application.withdraw', $application) }}"
                                      method="POST" class="inline-block"
                                      onsubmit="return confirm('Are you sure you want to withdraw this application?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Withdraw" class="text-red-500 hover:text-red-700">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">You haven't submitted any applications yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($applications->hasPages())
            <div class="p-4 border-t border-gray-200 bg-gray-50">
                {{ $applications->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection
