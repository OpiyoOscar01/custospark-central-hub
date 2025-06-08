@extends('layouts.employee')

@section('content')
<div class="py-2 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('consultations.index') }}" class="hover:text-gray-700">Consultations</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">{{ $consultation->full_name }}</span>
    </nav>

    <!-- Consultation Card -->
    <div class="bg-white shadow-lg rounded-xl border border-gray-200 mt-4">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                    <i class="bi bi-person-lines-fill text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $consultation->full_name }}</h1>
                    <p class="text-sm text-gray-500">{{ $consultation->email }}</p>
                </div>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Consultation Info -->
            <div>
                <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                    <i class="bi bi-info-circle text-blue-600"></i>
                    Consultation Details
                </h2>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                    <div>
                        <dt class="font-medium">Phone</dt>
                        <dd class="mt-1">
                            {{ $consultation->custom_country_code ?? $consultation->country_code }} {{ $consultation->phone }}
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium">Timezone</dt>
                        <dd class="mt-1">{{ $consultation->timezone }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium">Preferred Date</dt>
                        <dd class="mt-1">{{ \Carbon\Carbon::parse($consultation->preferred_date)->format('l, d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium">Preferred Time</dt>
                        <dd class="mt-1">
                            {{ \Carbon\Carbon::parse($consultation->preferred_start)->format('g:i A') }}
                            -
                            {{ \Carbon\Carbon::parse($consultation->preferred_end)->format('g:i A') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium">Meeting Type</dt>
                        <dd class="mt-1 capitalize">{{ str_replace('_', ' ', $consultation->meeting_type) }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium">Status</dt>
                        <dd class="mt-1 capitalize">
                            @php
                                $statusColors = [
                                    'pending' => 'text-yellow-600',
                                    'scheduled' => 'text-blue-600',
                                    'completed' => 'text-green-600',
                                    'cancelled' => 'text-red-600',
                                ];
                            @endphp
                            <span class="font-semibold {{ $statusColors[$consultation->status] ?? 'text-gray-600' }}">
                                {{ ucfirst($consultation->status) }}
                            </span>
                        </dd>
                    </div>
                    @if ($consultation->organization)
                        <div class="md:col-span-2">
                            <dt class="font-medium">Organization</dt>
                            <dd class="mt-1 text-gray-700">{{ $consultation->organization }}</dd>
                        </div>
                    @endif
                    @if ($consultation->message)
                        <div class="md:col-span-2">
                            <dt class="font-medium">Message</dt>
                            <dd class="mt-1 text-gray-700 whitespace-pre-line">{{ $consultation->message }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Actions -->
            <div class="flex justify-end pt-4 border-t border-gray-200">
                <a href="{{ route('consultations.edit', $consultation->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                    <i class="bi bi-pencil-square mr-2"></i> Edit Consultation
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
