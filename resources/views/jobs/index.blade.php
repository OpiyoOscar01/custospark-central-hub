@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Jobs Management</span>
    </nav>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Jobs -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
            <div class="p-5">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="bg-blue-100 text-blue-600 rounded-xl p-3 border border-blue-200">
                            <i class="bi bi-briefcase text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Jobs</dt>
                            <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['total'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Jobs -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
            <div class="p-5">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="bg-green-100 text-green-600 rounded-xl p-3 border border-green-200">
                            <i class="bi bi-check-circle text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Published Jobs</dt>
                            <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['published'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Draft Jobs -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
            <div class="p-5">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="bg-yellow-100 text-yellow-600 rounded-xl p-3 border border-yellow-200">
                            <i class="bi bi-pencil-square text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Draft Jobs</dt>
                            <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['draft'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Applications -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
            <div class="p-5">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="bg-purple-100 text-purple-600 rounded-xl p-3 border border-purple-200">
                            <i class="bi bi-people text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Applications</dt>
                            <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['applications'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jobs List -->
    <div class="mt-8 bg-white shadow-lg rounded-xl border border-gray-200">
        <!-- Header -->
       <div class="p-6 border-b border-gray-200">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                <i class="bi bi-briefcase text-blue-600 text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Job Listings</h1>
                <p class="mt-1 text-sm text-gray-500">Manage your job postings and applications</p>
            </div>
        </div>
        <a href="{{ route('jobs.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700">
            <i class="bi bi-plus-lg mr-2"></i>
            Post New Job
        </a>
    </div>
</div>


        <div class="p-6">
            <!-- Search and Filters -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="relative">
                    <input type="text" 
                           placeholder="Search jobs..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="bi bi-search text-gray-400"></i>
                    </div>
                </div>
                <div>
                    <select class="block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Departments</option>
                        <option value="engineering">Engineering</option>
                        <option value="design">Design</option>
                        <option value="marketing">Marketing</option>
                        <option value="sales">Sales</option>
                    </select>
                </div>
                <div>
                    <select class="block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
            </div>

            <!-- Jobs Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applications</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($jobs as $job)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $job->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $job->type }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $job->department }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="bi bi-geo-alt mr-1"></i>
                                        {{ $job->is_remote ? 'Remote' : $job->location }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $job->applications->count() }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ $job->applications->where('status', 'hired')->count() }} hired
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($job->status === 'published') bg-green-100 text-green-800
                                        @elseif($job->status === 'draft') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($job->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">
                                        @if($job->deadline)
                                            {{ $job->deadline->format('M d, Y') }}
                                        @else
                                            No deadline
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="{{ route('jobs.show', $job) }}" 
                                           class="text-blue-600 hover:text-blue-900" title="View Job Details">
                                            <i class="bi bi-eye"></i>
                                            <span class="sr-only">View</span>
                                        </a>
                                
                                        <a href="{{ route('jobs.edit', $job) }}" 
                                           class="text-yellow-600 hover:text-yellow-900" title="Edit Job">
                                            <i class="bi bi-pencil"></i>
                                            <span class="sr-only">Edit</span>
                                        </a>
                                
                                        @if($job->status === 'draft')
                                            <form action="{{ route('jobs.publish', $job) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" title="Publish Job" class="text-green-600 hover:text-green-900">
                                                    <i class="bi bi-check-circle"></i>
                                                    <span class="sr-only">Publish</span>
                                                </button>
                                            </form>
                                        @elseif($job->status === 'published')
                                            <form action="{{ route('jobs.close', $job) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button title="Close Job Opening" type="submit" class="text-red-600 hover:text-red-900">
                                                    <i class="bi bi-x-circle"></i>
                                                    <span class="sr-only">Close</span>
                                                </button>
                                            </form>
                                        @endif
                                
                                        {{-- 🗑️ Delete Option --}}
                                        <form action="{{ route('jobs.destroy', $job) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this job? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete this Job" class="text-gray-600 hover:text-gray-900">
                                                <i class="bi bi-trash"></i>
                                                <span class="sr-only">Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    <div class="flex flex-col items-center py-8">
                                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                                            <i class="bi bi-briefcase text-2xl text-blue-600"></i>
                                        </div>
                                        <h3 class="text-sm font-medium text-gray-900">No Jobs Found</h3>
                                        <p class="mt-1 text-sm text-gray-500">Get started by posting a new job.</p>
                                        <div class="mt-4">
                                            <a href="{{ route('jobs.create') }}" 
                                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                                                <i class="bi bi-plus-lg mr-2"></i>
                                                Post New Job
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($jobs->hasPages())
                <div class="border-t border-gray-200 px-6 py-4">
                    {{ $jobs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection