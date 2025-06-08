@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
<nav class="mb-4 flex flex-col sm:flex-row sm:items-center
    space-y-1 sm:space-y-0 sm:space-x-2 text-sm text-gray-500"
>
    <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>

    <i class="bi bi-chevron-right text-xs self-center sm:self-auto"></i>

    <a href="{{ route('user.applications.all') }}" class="hover:text-gray-700">My Applications</a>

    <i class="bi bi-chevron-right text-xs self-center sm:self-auto"></i>

    <span class="text-gray-900">{{$job->title}}</span>
</nav>


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Application Details -->
            <div class="bg-white shadow-lg rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                            <i class="bi bi-file-text text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Application Details</h1>
                            <p class="mt-1 text-sm text-gray-500">{{ $job->title }} • {{ $job->department }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Application Overview -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Overview</h2>
                        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Application Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $application->created_at->format('M d, Y') }}</dd>
                            </div>
                            <div>
                             <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
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
                        </dd>

                            </div>
                           <div>
                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $application->updated_at->format('M d, Y') }}</dd>
                    </div>

                  <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-xl shadow-sm">
                    <dt class="text-sm font-semibold text-gray-700 mb-1 flex items-center">
                        <svg class="w-4 h-4 mr-1.5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8s-9-3.582-9-8 4.03-8 9-8 9 3.582 9 8z" />
                        </svg>
                        Internal Notes
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                        @if(Str::contains($application->internal_notes, 'http'))
                            {!! Str::of($application->internal_notes)->replaceMatches('/https?:\/\/[^\s]+/', '<a href="$0" class="text-indigo-600 underline hover:text-indigo-800" target="_blank">$0</a>') !!}
                        @else
                            {{ $application->internal_notes ?? '—' }}
                        @endif
                    </dd>
                </div>


                            <div>
                                <dt class="text-sm font-medium text-gray-500">Documents</dt>
                                <dd class="mt-1 space-x-2">
                                    <a href="{{ Storage::url($application->resume_path) }}" 
                                       class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                        <i class="bi bi-file-pdf text-red-600 mr-1"></i>
                                        Resume
                                    </a>
                                    @if($application->cover_letter_path)
                                        <a href="{{ Storage::url($application->cover_letter_path) }}" 
                                           class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                            <i class="bi bi-file-text text-blue-600 mr-1"></i>
                                            Cover Letter
                                        </a>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>

                    @if($application->additional_information)
                        <!-- Additional Information -->
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Additional Information</h2>
                            <div class="bg-gray-50 rounded-lg p-4 text-sm text-gray-700">
                                {{ $application->additional_information }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Application Timeline -->
            <div class="bg-white shadow-lg rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Application Timeline</h2>
                </div>

                <div class="p-6">
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center ring-8 ring-white">
                                                <i class="bi bi-send text-blue-600"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">Application submitted</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time datetime="{{ $application->created_at->format('Y-m-d') }}">
                                                    {{ $application->created_at->format('M d, Y') }}
                                                </time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            @if($application->status !== 'pending')
                                <li>
                                    <div class="relative pb-8">
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center ring-8 ring-white">
                                                    <i class="bi bi-check text-green-600"></i>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">Application reviewed</p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <time datetime="{{ $application->reviewed_at?->format('Y-m-d') }}">
                                                        {{ $application->reviewed_at?->format('M d, Y') }}
                                                    </time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif

                            @if($application->status === 'interview_scheduled')
                                <li>
                                    <div class="relative pb-8">
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center ring-8 ring-white">
                                                    <i class="bi bi-calendar text-purple-600"></i>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">Interview scheduled</p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <time datetime="{{ $application->interview?->scheduled_at?->format('Y-m-d') }}">
                                                        {{ $application->interview?->scheduled_at?->format('M d, Y') }}
                                                    </time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif

                            @if($application->status === 'hired')
                                <li>
                                    <div class="relative pb-8">
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center ring-8 ring-white">
                                                    <i class="bi bi-person-check text-green-600"></i>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">Hired</p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <time datetime="{{ $application->updated_at->format('Y-m-d') }}">
                                                        {{ $application->updated_at->format('M d, Y') }}
                                                    </time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- CompanyJob Details -->
            <div class="bg-white shadow-lg rounded-xl border border-gray-200">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">CompanyJob Details</h2>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Position</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $job->title }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Department</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $job->department }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Location</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($job->is_remote)
                                    Remote
                                @else
                                    {{ $job->location }}
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Employment Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($job->type) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white shadow-lg rounded-xl border border-gray-200">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h2>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $application->applicant->last_name.' '.$application->applicant->first_name}}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $application->applicant->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $application->applicant->phone ?? "Not Provided.Update your contact under profile Settings." }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection