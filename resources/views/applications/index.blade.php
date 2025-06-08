@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <a href="{{ route('jobs.index') }}" class="hover:text-gray-700">Jobs</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Applications</span>
    </nav>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-5">
        <!-- Total Applications -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
            <div class="p-5">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="bg-blue-100 text-blue-600 rounded-xl p-3 border border-blue-200">
                            <i class="bi bi-file-text text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total</dt>
                            <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['total'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Applications -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
            <div class="p-5">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="bg-yellow-100 text-yellow-600 rounded-xl p-3 border border-yellow-200">
                            <i class="bi bi-hourglass-split text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                            <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['pending'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shortlisted -->
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
                            <dt class="text-sm font-medium text-gray-500 truncate">Shortlisted</dt>
                            <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['shortlisted'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Interviewing -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
            <div class="p-5">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="bg-purple-100 text-purple-600 rounded-xl p-3 border border-purple-200">
                            <i class="bi bi-camera-video text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Interviewing</dt>
                            <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['interviewing'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hired -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
            <div class="p-5">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="bg-indigo-100 text-indigo-600 rounded-xl p-3 border border-indigo-200">
                            <i class="bi bi-person-check text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Hired</dt>
                            <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['hired'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Applications List -->
    <div class="mt-8 bg-white shadow-lg rounded-xl border border-gray-200">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                        <i class="bi bi-people text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Job Applications</h1>
                        <p class="mt-1 text-sm text-gray-500">Manage and track all job applications</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6">
            <!-- Search and Filters -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="relative">
                    <input type="text" 
                           placeholder="Search applicants..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="bi bi-search text-gray-400"></i>
                    </div>
                </div>
                <div>
                    <select class="block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Positions</option>
                        @foreach($jobs as $job)
                            <option value="{{ $job->id }}">{{ $job->title ?? 'NA' }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select class="block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="pending">Pending Review</option>
                        <option value="shortlisted">Shortlisted</option>
                        <option value="interviewing">Interviewing</option>
                        <option value="hired">Hired</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
            </div>

            <!-- Applications Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documents</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($applications as $application)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0 rounded-full bg-gray-200"></div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $application->applicant->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $application->applicant->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $application->job->title ?? "NA" }}</div>
                                    <div class="text-sm text-gray-500">{{ $application->job->department ?? "NA"}}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $application->created_at->format('M d, Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $application->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select onchange="updateStatus(this, '{{ $application->id }}')"
                                            class="block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                        <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending Review</option>
                                        <option value="reviewing" {{ $application->status === 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                                        <option value="shortlisted" {{ $application->status === 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                        <option value="interview_scheduled" {{ $application->status === 'interview_scheduled' ? 'selected' : '' }}>Interview Scheduled</option>
                                        <option value="interviewed" {{ $application->status === 'interviewed' ? 'selected' : '' }}>Interviewed</option>
                                        <option value="offered" {{ $application->status === 'offered' ? 'selected' : '' }}>Offered</option>
                                        <option value="hired" {{ $application->status === 'hired' ? 'selected' : '' }}>Hired</option>
                                        <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <a href="{{Storage::url($application->resume_path)}}" 
                                           class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <i class="bi bi-file-pdf text-red-600 mr-1"></i>
                                            Resume
                                        </a>
                                        @if($application->cover_letter_path)
                                            <a href="{{ Storage::url($application->cover_letter_path)}}" 
                                               class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <i class="bi bi-file-text text-blue-600 mr-1"></i>
                                                Cover Letter
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="{{ route('applications.show', $application) }}" 
                                           class="text-blue-600 hover:text-blue-900">
                                            <i class="bi bi-eye"></i>
                                            <span class="sr-only">View</span>
                                        </a>
                                        {{-- <button type="button" 
                                                onclick="addNote('{{ $application->id }}')"
                                                class="text-gray-600 hover:text-gray-900">
                                            <i class="bi bi-pencil"></i>
                                            <span class="sr-only">Add Note</span>
                                        </button> --}}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    <div class="flex flex-col items-center py-8">
                                        <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                            <i class="bi bi-people text-2xl text-gray-400"></i>
                                        </div>
                                        <h3 class="text-sm font-medium text-gray-900">No Applications Found</h3>
                                        <p class="mt-1 text-sm text-gray-500">No applications have been submitted yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($applications->hasPages())
                <div class="border-t border-gray-200 px-6 py-4">
                    {{ $applications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Note Modal -->
<div id="noteModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Add Internal Note</h3>
        <form id="noteForm" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="internal_notes" class="block text-sm font-medium text-gray-700">Note</label>
                    <textarea id="internal_notes" name="internal_notes" rows="4"
                              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="closeNoteModal()"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                    Cancel
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Save Note
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function updateStatus(select, applicationId) {
    fetch(`/applications/${applicationId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            status: select.value
        })
    }).then(response => {
        if (!response.ok) throw new Error('Failed to update status');
        // Show success message
        // You can implement a toast notification here
    }).catch(error => {
        console.error('Error:', error);
        // Show error message
    });
}

function addNote(applicationId) {
    const modal = document.getElementById('noteModal');
    const form = document.getElementById('noteForm');
    form.action = `/applications/${applicationId}/status`;
    modal.classList.remove('hidden');
}

function closeNoteModal() {
    document.getElementById('noteModal').classList.add('hidden');
}
</script>
@endpush
@endsection