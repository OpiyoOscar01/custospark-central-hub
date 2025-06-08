@extends('layouts.employee')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <i class="bi bi-briefcase text-blue-600 text-xl"></i>
                    </div>
                    <div>
                @php
                    $totalPositions = 0;
                @endphp

                @foreach ($jobs as $job)
                    @if ($job->status === 'published')
                        @php
                            $totalPositions += $job->positions_available;
                        @endphp
                    @endif
                @endforeach
                        <p class="text-sm text-gray-600">Total Positions</p>
                        <p class="text-2xl font-bold text-gray-900">{{$totalPositions}}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center gap-4">
                    <div class="bg-green-100 p-3 rounded-lg">
                        <i class="bi bi-building text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Departments</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $departments->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center gap-4">
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <i class="bi bi-geo-alt text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Locations</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $locations->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center gap-4">
                    <div class="bg-yellow-100 p-3 rounded-lg">
                        <i class="bi bi-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Closing Soon</p>
                        <p class="text-2xl font-bold text-gray-900">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Explore Opportunities</h1>
            <p class="mt-2 text-sm text-gray-600">Join our team and be part of something great</p>
        </div>

        @hasAppRole(['super-admin','admin'],'custospark')
        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
            <form action="{{ route('jobs.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-search text-gray-400"></i>
                        </div>
                        <input type="text" 
                               name="search" 
                               id="search" 
                               value="{{ request('search') }}"
                               placeholder="Search jobs..."
                               class="block w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <!-- Department -->
                <div>
                    <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                    <select name="department" 
                            id="department" 
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>
                                {{ $dept }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Employment Type</label>
                    <select name="type" 
                            id="type" 
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">All Types</option>
                        <option value="full-time" {{ request('type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part-time" {{ request('type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                        <option value="contract" {{ request('type') == 'contract' ? 'selected' : '' }}>Contract</option>
                    </select>
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                    <select name="location" 
                            id="location" 
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">All Locations</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>
                                {{ $loc }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Actions -->
                <div class="md:col-span-4 flex justify-end space-x-2">
                    <a href="{{ route('jobs.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="bi bi-x-circle mr-2"></i>
                        Clear
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="bi bi-funnel mr-2"></i>
                        Filter
                    </button>
                </div>
            </form>
        </div>
        @endhasAppRole

        <!-- Job Listings -->
        <div class="space-y-6">
            @forelse($jobs as $job)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow duration-200">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <!-- Job Title and Basic Info -->
                        <div class="mb-4 md:mb-0">
                            <h2 class="text-xl font-semibold text-gray-900">
                                <a href="{{ route('jobs.show', $job) }}" class="hover:text-blue-600 flex items-center gap-2">
                                    {{ $job->title }}
                                    @if(Carbon\Carbon::parse($job->created_at)->diffInDays() < 7)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            New
                                        </span>
                                    @endif
                                </a>
                            </h2>
                            <div class="mt-1 flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500">
                                <span class="flex items-center">
                                    <i class="bi bi-building mr-1"></i>
                                    {{ $job->department }}
                                </span>
                                <span class="flex items-center">
                                    <i class="bi bi-geo-alt mr-1"></i>
                                    {{ $job->location }}
                                    @if($job->is_remote)
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Remote
                                        </span>
                                    @endif
                                </span>
                                <span class="flex items-center">
                                    <i class="bi bi-briefcase mr-1"></i>
                                    {{ Str::title(str_replace('_', ' ', $job->type)) }}
                                </span>
                            </div>
                        </div>

                        <!-- Salary Information -->
                        <div class="flex flex-col items-end gap-2">
                            @if($job->salary_min || $job->salary_max)
                                <div class="text-sm text-gray-600">
                                    <span class="font-medium">
                                        {{ $job->salary_currency }}
                                        {{ number_format($job->salary_min) }}
                                        @if($job->salary_max)
                                            - {{ number_format($job->salary_max) }}
                                        @endif
                                    </span>
                                    <span class="text-gray-500">/year</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Job Description -->
                    <div class="mt-4">
                        <p class="text-sm text-gray-600 line-clamp-2">
                            {{ $job->description }}
                        </p>
                    </div>

                    <!-- Tags and Additional Info -->
                    <div class="mt-4 flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $job->experience_level }}
                        </span>
                        @if($job->deadline)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ Carbon\Carbon::parse($job->deadline)->isPast() ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                <i class="bi bi-clock mr-1"></i>
                                {{ Carbon\Carbon::parse($job->deadline)->isPast() ? 'Closed' : 'Closes ' . Carbon\Carbon::parse($job->deadline)->diffForHumans() }}
                            </span>
                        @endif
                        @if($job->positions_available > 1)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                <i class="bi bi-people mr-1"></i>
                                {{ $job->positions_available }} positions
                            </span>
                        @endif
                    </div>

                    <!-- View Details Link -->
                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('applications.create', $job) }}" 
                        class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                         <i class="bi bi-info-circle mr-1"></i> 
                         View Details & Apply
                         <i class="bi bi-box-arrow-in-right ml-2"></i>
                     </a>
                     
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                        <i class="bi bi-search text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No jobs found</h3>
                    <p class="text-sm text-gray-500">
                        We couldn't find any jobs matching your criteria. Try adjusting your filters or check back later.
                    </p>
                </div>
            @endforelse

            <!-- Pagination -->
            @if($jobs->hasPages())
                <div class="mt-6">
                    {{ $jobs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection