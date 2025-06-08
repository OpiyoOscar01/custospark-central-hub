@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Consultations</h1>
            <p class="mt-2 text-sm text-gray-600">Manage all incoming consultation requests and their statuses</p>
        </div>
        <div class="mt-4 md:mt-0 flex gap-2">
            <a href="#"
               class="inline-flex items-center px-4 py-2 rounded-lg shadow-sm text-sm text-white bg-indigo-600 hover:bg-indigo-700">
                <i class="bi bi-calendar-week mr-2"></i> View Calendar
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
     <form action="{{ route('consultations.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-4">
        @php
            
            $timezones = collect(timezone_identifiers_list());
        @endphp

    <!-- Timezone -->
  <!-- Timezone -->
<div>
    <label for="timezone" class="block text-sm font-medium text-gray-700 mb-1">Timezone</label>
    <select name="timezone" id="timezone"
            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 sm:text-sm">
        <option value="">All</option>
        @foreach($timezones as $tz)
            <option value="{{ $tz }}" {{ request('timezone') == $tz ? 'selected' : '' }}>
                {{ $tz }}
            </option>
        @endforeach
    </select>
</div>


    <!-- Preferred Date (optional day-based filter) -->
    <div>
        <label for="preferred_day" class="block text-sm font-medium text-gray-700 mb-1">Preferred Day</label>
        <select name="preferred_day" id="preferred_day"
                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 sm:text-sm">
            <option value="">Any</option>
            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                <option value="{{ $day }}" {{ request('preferred_day') == $day ? 'selected' : '' }}>
                    {{ $day }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Start Time -->
    <div>
        <label for="preferred_start" class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
        <input type="time" name="preferred_start" id="preferred_start" value="{{ request('preferred_start') }}"
               class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 sm:text-sm">
    </div>

    <!-- End Time -->
    <div>
        <label for="preferred_end" class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
        <input type="time" name="preferred_end" id="preferred_end" value="{{ request('preferred_end') }}"
               class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 sm:text-sm">
    </div>

    <!-- Meeting Type -->
    <div>
        <label for="meeting_type" class="block text-sm font-medium text-gray-700 mb-1">Meeting Type</label>
        <select name="meeting_type" id="meeting_type"
                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 sm:text-sm">
            <option value="">All</option>
            @foreach(['video', 'phone', 'in_person'] as $type)
                <option value="{{ $type }}" {{ request('meeting_type') == $type ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_', ' ', $type)) }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Status -->
    <div>
        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <select name="status" id="status"
                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 sm:text-sm">
            <option value="">All</option>
            @foreach(['pending', 'scheduled', 'completed', 'cancelled'] as $status)
                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Buttons -->
    <div class="col-span-full flex justify-end gap-2">
        <a href="{{ route('consultations.index') }}"
           class="inline-flex items-center px-4 py-2 text-sm rounded-lg bg-white text-gray-700 border hover:bg-gray-50">
            <i class="bi bi-x-circle mr-1"></i> Clear
        </a>
        <button type="submit"
                class="inline-flex items-center px-4 py-2 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
            <i class="bi bi-filter-circle mr-1"></i> Filter
        </button>
    </div>
</form>

    </div>

    <!-- Consultations Table -->
    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Phone</th>
                    <th class="px-4 py-3">Preferred Days</th>
                    <th class="px-4 py-3">Meeting Type</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($consultations as $consultation)
                    <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                        <td class="px-4 py-3">{{ $loop->iteration + ($consultations->currentPage() - 1) * $consultations->perPage() }}</td>
                        <td class="px-4 py-3">{{ $consultation->full_name }}</td>
                        <td class="px-4 py-3">{{ $consultation->email }}</td>
                        <td class="px-4 py-3">{{ $consultation->phone }}</td>
                        <td class="px-4 py-3">{{ $consultation->preferred_date }}

                        </td>
                        <td class="px-4 py-3 capitalize">{{ $consultation->meeting_type }}</td>
                        <td class="px-4 py-3 capitalize">{{ $consultation->status }}</td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('consultations.show', $consultation) }}"
                               class="text-blue-600 hover:text-blue-800" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('consultations.edit', $consultation) }}"
                               class="text-yellow-600 hover:text-yellow-800" title="Update Status">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('consultations.destroy', $consultation) }}"
                                  method="POST" class="inline-block"
                                  onsubmit="return confirm('Are you sure you want to delete this consultation?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-6 text-gray-500 text-center">No consultations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $consultations->withQueryString()->links() }}
    </div>
</div>
@endsection
