@php
    use Carbon\Carbon;
@endphp

@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Calendar</span>
    </nav>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                        <i class="bi bi-calendar-week text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Calendar</h1>
                        <p class="mt-1 text-sm text-gray-500">View and manage your schedule</p>
                        <p class="mt-1 text-sm text-gray-500 font-medium">
                            Today: <span class="text-gray-800 font-semibold">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</span>
                        </p>
                    </div>
                </div>
        
                <div class="flex items-center gap-4">
                    <!-- Date Navigation -->
                    <div class="flex items-center gap-2 mr-4">
                        <a href="{{ request()->fullUrlWithQuery(['date' => (function() use ($currentView, $currentDate) {
                            switch($currentView) {
                                case 'day':
                                    return $currentDate->copy()->subDay();
                                case 'week':
                                    return $currentDate->copy()->subWeek();
                                case 'month':
                                    return $currentDate->copy()->subMonth();
                                case 'year':
                                    return $currentDate->copy()->subYear();
                                default:
                                    return $currentDate->copy();
                            }
                        })()->format('Y-m-d')]) }}" 
                           class="p-2 text-gray-400 hover:text-gray-600">
                            <i class="bi bi-chevron-left text-xl"></i>
                        </a>
                        <h2 class="text-lg font-semibold text-gray-900">
                            @if($currentView === 'day')
                                {{ $currentDate->format('F j, Y') }}
                            @elseif($currentView === 'week')
                                {{ $calendar['startDate']->format('M j') }} - {{ $calendar['endDate']->format('M j, Y') }}
                            @elseif($currentView === 'month')
                                {{ $currentDate->format('F Y') }}
                            @else
                                {{ $currentDate->format('Y') }}
                            @endif
                        </h2>
                        <a href="{{ request()->fullUrlWithQuery(['date' => (function() use ($currentView, $currentDate) {
                            switch($currentView) {
                                case 'day':
                                    return $currentDate->copy()->addDay();
                                case 'week':
                                    return $currentDate->copy()->addWeek();
                                case 'month':
                                    return $currentDate->copy()->addMonth();
                                case 'year':
                                    return $currentDate->copy()->addYear();
                                default:
                                    return $currentDate->copy();
                            }
                        })()->format('Y-m-d')]) }}" 
                           class="p-2 text-gray-400 hover:text-gray-600">
                            <i class="bi bi-chevron-right text-xl"></i>
                        </a>
                    </div>
        
                    <!-- View Toggle -->
                    <div class="flex rounded-lg shadow-sm">
                        <a href="{{ route('calendar.index', ['view' => 'year']) }}" 
                           class="px-4 py-2 text-sm font-medium {{ $currentView === 'year' ? 'text-white bg-blue-600 border-blue-600' : 'text-gray-700 bg-white border-gray-300' }} border rounded-l-lg hover:bg-blue-700 hover:text-white">
                            <i class="bi bi-calendar mr-1"></i>
                            Year
                        </a>
                        <a href="{{ route('calendar.index', ['view' => 'month']) }}" 
                           class="px-4 py-2 text-sm font-medium {{ $currentView === 'month' ? 'text-white bg-blue-600 border-blue-600' : 'text-gray-700 bg-white border-gray-300' }} border-l-0 border hover:bg-blue-700 hover:text-white">
                            <i class="bi bi-grid-3x3 mr-1"></i>
                            Month
                        </a>
                        <a href="{{ route('calendar.index', ['view' => 'week']) }}" 
                           class="px-4 py-2 text-sm font-medium {{ $currentView === 'week' ? 'text-white bg-blue-600 border-blue-600' : 'text-gray-700 bg-white border-gray-300' }} border-l-0 border hover:bg-blue-700 hover:text-white">
                            <i class="bi bi-calendar-week mr-1"></i>
                            Week
                        </a>
                        <a href="{{ route('calendar.day', ['view' => 'day']) }}" 
                           class="px-4 py-2 text-sm font-medium {{ $currentView === 'day' ? 'text-white bg-blue-600 border-blue-600' : 'text-gray-700 bg-white border-gray-300' }} border-l-0 border rounded-r-lg hover:bg-blue-700 hover:text-white">
                            <i class="bi bi-calendar-day mr-1"></i>
                            Day
                        </a>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="p-6">
            @if($currentView === 'year')
                <!-- Year View -->
                <div class="grid grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach($calendar['months'] as $monthKey => $month)
                        <div class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-sm font-medium {{ $month['isCurrentMonth'] ? 'text-blue-600' : 'text-gray-900' }}">
                                    {{ $month['date']->format('F') }}
                                </h3>
                                <span class="text-xs text-gray-500">{{ $month['date']->format('Y') }}</span>
                            </div>
                            <div class="space-y-1">
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <span>Tasks</span>
                                    <span class="font-medium">{{ $month['taskCount'] }}</span>
                                </div>
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <span>Milestones</span>
                                    <span class="font-medium">{{ $month['milestoneCount'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @elseif($currentView === 'day')
                <!-- Day View -->
                <div class="space-y-1">
                    @php
                        $hasMilestone = false; // Variable to check if milestones exist
                    @endphp
                
                    @foreach($calendar['hours'] as $hour => $data)
                        <div class="flex group {{ now()->format('H') == $hour ? 'bg-blue-50' : '' }}">
                            <div class="w-20 py-2 text-right text-sm text-gray-500 pr-4">
                                {{ $data['time'] }}
                            </div>
                            <div class="flex-1 min-h-[3rem] border-l border-gray-200 pl-4">
                                @foreach($data['items'] as $item)
                                    <div class="mb-1">
                                        @if($item['type'] === 'task')
                                            <div class="text-sm p-2 rounded-lg bg-blue-50 border border-blue-100 text-blue-700 hover:bg-blue-100">
                                                <i class="bi bi-check-circle mr-1"></i>
                                                {{ $item['title'] }}
                                            </div>
                                        @elseif($item['type'] === 'milestone') 
                                            @php
                                                $hasMilestone = true; // Mark that a milestone was found
                                            @endphp
                                            <div class="text-sm p-2 rounded-lg bg-green-50 border border-green-100 text-green-700 hover:bg-green-100">
                                                <i class="bi bi-trophy mr-1"></i>
                                                {{ $item['title'] }}
                                            </div>
                                        @else
                                            <div class="text-sm p-2 rounded-lg bg-purple-50 border border-purple-100 text-purple-700 hover:bg-purple-100">
                                                <i class="bi bi-flag mr-1"></i>
                                                {{ $item['title'] }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                
                    @if(!$hasMilestone)
                        <div class="mt-4 text-center text-sm text-gray-500">
                            No milestones for today.
                        </div>
                    @endif
                </div>
                
            @elseif($currentView === 'week')
                <!-- Week View -->
               <div class="grid grid-cols-7 gap-px rounded-lg overflow-hidden bg-gray-200 border border-gray-200">
    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
        <div class="bg-gray-50 py-2 text-center">
            <span class="text-sm font-medium text-gray-900">{{ $dayName }}</span>
        </div>
    @endforeach
    
    @foreach($calendar['days'] as $dateKey => $day)
        <div class="bg-white min-h-[140px] p-3 {{ $day['isToday'] ? 'bg-blue-50' : '' }}">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium {{ $day['isToday'] ? 'text-blue-600' : 'text-gray-900' }}">
                    {{ $day['date']->format('j') }}
                </span>
            </div>
            <div class="space-y-1">
                @if(count($day['items']) > 0)
                    @foreach($day['items'] as $item)
                        @if($item['type'] === 'task')
                            <div class="text-xs p-1.5 rounded-lg bg-blue-50 border border-blue-100 text-blue-700 truncate hover:bg-blue-100">
                                <i class="bi bi-check-circle mr-1"></i>
                                {{ $item['title'] }}
                            </div>
                        @else
                            <div class="text-xs p-1.5 rounded-lg bg-purple-50 border border-purple-100 text-purple-700 truncate hover:bg-purple-100">
                                <i class="bi bi-flag mr-1"></i>
                                {{ $item['title'] }}
                            </div>
                        @endif
                    @endforeach
                @else
                    {{-- <div class="text-xs text-gray-400 italic">No tasks or milestones</div> --}}
                @endif
            </div>
        </div>
    @endforeach
</div>

            @else
                <!-- Month View -->
                <div class="grid grid-cols-7 gap-px rounded-lg overflow-hidden bg-gray-200 border border-gray-200">
                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                        <div class="bg-gray-50 py-2 text-center">
                            <span class="text-sm font-medium text-gray-900">{{ $dayName }}</span>
                        </div>
                    @endforeach
                    
                    @foreach($calendar['weeks'] as $week)
                        @foreach($week as $dateKey => $day)
                            <div class="bg-white min-h-[140px] p-3 {{ !$day['isCurrentMonth'] ? 'bg-gray-50' : '' }} {{ $day['isToday'] ? 'bg-blue-50' : '' }}">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium {{ $day['isToday'] ? 'text-blue-600' : ($day['isCurrentMonth'] ? 'text-gray-900' : 'text-gray-400') }}">
                                        {{ $day['date']->format('j') }}
                                    </span>
                                </div>
                                <div class="space-y-1">
                                    @if(count($day['items']) > 0)
                                        @foreach($day['items'] as $item)
                                            @if($item['type'] === 'task')
                                                <div class="text-xs p-1.5 rounded-lg bg-blue-50 border border-blue-100 text-blue-700 truncate hover:bg-blue-100">
                                                    <i class="bi bi-check-circle mr-1"></i>
                                                    {{ $item['title'] }}
                                                </div>
                                            @else
                                                <div class="text-xs p-1.5 rounded-lg bg-purple-50 border border-purple-100 text-purple-700 truncate hover:bg-purple-100">
                                                    <i class="bi bi-flag mr-1"></i>
                                                    {{ $item['title'] }}
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        {{-- <div class="text-xs text-gray-400 italic">No tasks or milestones</div> --}}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
                
            @endif

            <!-- Legend -->
            <div class="mt-6 flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-blue-50 border border-blue-100 rounded-full"></div>
                    <span class="text-sm text-gray-600">Tasks</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-purple-50 border border-purple-100 rounded-full"></div>
                    <span class="text-sm text-gray-600">Milestones</span>
                </div>
                <button type="button" class="ml-auto inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                    <i class="bi bi-plus-lg mr-2"></i>
                    Add Event
                </button>
            </div>
        </div>
    </div>
</div>
@endsection