@extends('layouts.employee')

@section('content')
@php use Carbon\Carbon; @endphp
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <a href="{{ route('calendar.index') }}" class="hover:text-gray-700">Calendar</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Day View</span>
    </nav>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                    <i class="bi bi-calendar-day text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Day View</h1>
                    <p class="mt-1 text-sm text-gray-500">All tasks and milestones for today</p>
                </div>
            </div>

            <div class="flex rounded-lg shadow-sm">
                <a href="{{ route('calendar.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-50">
                    <i class="bi bi-grid-3x3 mr-1"></i> Month
                </a>
                <a href="{{ route('calendar.week') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">
                    <i class="bi bi-calendar-week mr-1"></i> Week
                </a>
                <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-r-lg hover:bg-blue-700">
                    <i class="bi bi-calendar-day mr-1"></i> Day
                </button>
            </div>
        </div>

        <div class="p-6 space-y-3">
            @foreach($calendar as $date => $items)
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">{{ Carbon::parse($date)->format('l, F jS') }}</h2>

                    @forelse($items as $item)
                        @if($item['type'] === 'task')
                            <div class="text-sm p-2 rounded-lg bg-blue-50 border border-blue-100 text-blue-700 hover:bg-blue-100 mb-2">
                                <i class="bi bi-check-circle mr-2"></i>{{ $item['title'] }}
                            </div>
                        @elseif($item['type'] === 'milestone')
                            <div class="text-sm p-2 rounded-lg bg-purple-50 border border-purple-100 text-purple-700 hover:bg-purple-100 mb-2">
                                <i class="bi bi-flag mr-2"></i>{{ $item['title'] }}
                            </div>
                        @endif
                    @empty
                        <p class="text-sm text-gray-500">No events for today.</p>
                    @endforelse
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
