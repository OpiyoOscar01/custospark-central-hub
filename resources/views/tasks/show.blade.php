@extends('layouts.employee')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header with enhanced borders -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="bg-indigo-100 rounded-lg p-2 border-2 border-indigo-200">
                <i class="bi bi-kanban text-2xl text-indigo-600"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Task Details</h2>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('tasks.edit', $task) }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-indigo-700 transition-all shadow-sm hover:shadow-md">
                <i class="bi bi-pencil-square mr-2"></i>
                Edit Task
            </a>
            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to delete this task?')" 
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-red-700 transition-all shadow-sm hover:shadow-md">
                    <i class="bi bi-trash mr-2"></i>
                    Delete Task
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Task Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Task Overview Card -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
                <div class="border-b-2 border-gray-100">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center mb-4">
                            <i class="bi bi-info-circle-fill text-indigo-600 mr-2"></i>
                            Task Information
                        </h3>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                            <div class="sm:col-span-2 p-4 rounded-lg border border-gray-100 bg-gray-50">
                                <dt class="text-sm font-medium text-gray-500">Title</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-medium">{{ $task->title }}</dd>
                            </div>
                            <div class="sm:col-span-2 p-4 rounded-lg border border-gray-100 bg-gray-50">
                                <dt class="text-sm font-medium text-gray-500">Description</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $task->description }}</dd>
                            </div>
                            <div class="p-4 rounded-lg border border-gray-100 bg-gray-50">
                                <dt class="text-sm font-medium text-gray-500">Project</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $task->project->name }}</dd>
                            </div>
                            <div class="p-4 rounded-lg border border-gray-100 bg-gray-50">
                                <dt class="text-sm font-medium text-gray-500">Due Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 flex items-center">
                                    <i class="bi bi-calendar-event text-indigo-600 mr-2"></i>
                                    {{ $task->due_date->format('M d, Y') }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Subtasks Card -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="bi bi-list-check text-indigo-600 mr-2"></i>
                            Subtasks
                        </h3>
                        <a href="{{ route('subtasks.create', ['task' => $task->id]) }}" 
                           class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-all shadow-sm hover:shadow-md border border-indigo-700">
                            <i class="bi bi-plus-lg mr-2"></i>
                            Add Subtask
                        </a>
                    </div>

                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Assigned To</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Due Date</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($task->subtasks as $subtask)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">
                                            {{ $subtask->title }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200">
                                            <div class="flex items-center">
                                                <span class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-sm mr-2 border border-indigo-200">
                                                    {{ strtoupper(substr($subtask->assignedUser->name, 0, 2)) }}
                                                </span>
                                                <span class="text-sm text-gray-900">{{ $subtask->assignedUser->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border
                                                @if($subtask->status === 'completed') bg-green-100 text-green-800 border-green-200
                                                @elseif($subtask->status === 'in_progress') bg-blue-100 text-blue-800 border-blue-200
                                                @else bg-gray-100 text-gray-800 border-gray-200 @endif">
                                                <i class="bi bi-circle-fill mr-1 text-xs"></i>
                                                {{ ucfirst(str_replace('_', ' ', $subtask->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-r border-gray-200">
                                            <i class="bi bi-calendar3 text-gray-400 mr-1"></i>
                                            {{ $subtask->due_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('subtasks.edit', $subtask) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 mr-3 border-b-2 border-transparent hover:border-indigo-600">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('subtasks.destroy', $subtask) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 border-b-2 border-transparent hover:border-red-600"
                                                        onclick="return confirm('Are you sure you want to delete this subtask?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                            <i class="bi bi-inbox text-gray-400 text-lg mr-2"></i>
                                            No subtasks created yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Status & Progress -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center mb-6 pb-3 border-b border-gray-200">
                        <i class="bi bi-graph-up text-indigo-600 mr-2"></i>
                        Status & Progress
                    </h3>
                    <div class="space-y-6">
                        <div class="p-4 rounded-lg border border-gray-100 bg-gray-50">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-500">Status</span>
                                <span class="px-3 py-1 rounded-full text-sm font-medium border
                                    @if($task->status === 'completed') bg-green-100 text-green-800 border-green-200
                                    @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800 border-blue-200
                                    @elseif($task->status === 'on_hold') bg-yellow-100 text-yellow-800 border-yellow-200
                                    @else bg-gray-100 text-gray-800 border-gray-200 @endif">
                                    <i class="bi bi-circle-fill mr-1 text-xs"></i>
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </div>
                        </div>
                        <div class="p-4 rounded-lg border border-gray-100 bg-gray-50">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-500">Priority</span>
                                <span class="px-3 py-1 rounded-full text-sm font-medium border
                                    @if($task->priority === 'urgent') bg-red-100 text-red-800 border-red-200
                                    @elseif($task->priority === 'high') bg-orange-100 text-orange-800 border-orange-200
                                    @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800 border-yellow-200
                                    @else bg-green-100 text-green-800 border-green-200 @endif">
                                    <i class="bi bi-flag-fill mr-1"></i>
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </div>
                        </div>
                        <div class="p-4 rounded-lg border border-gray-100 bg-gray-50">
                            <label class="text-sm font-medium text-gray-500 mb-2 block">Progress</label>
                            <div class="w-full bg-gray-200 rounded-full h-2 border border-gray-300">
                                <div class="bg-indigo-600 h-2 rounded-full transition-all duration-300" 
                                     style="width: {{ $task->progress }}%"></div>
                            </div>
                            <span class="text-sm text-gray-600 mt-2 inline-block">
                                <i class="bi bi-check2-circle mr-1"></i>
                                {{ $task->progress }}% Complete
                            </span>
                        </div>
                        <div class="p-4 rounded-lg border border-gray-100 bg-gray-50">
                            <label class="text-sm font-medium text-gray-500 mb-2 block">Assigned To</label>
                            <div class="flex items-center p-3 bg-white rounded-lg border border-gray-200">
                                <span class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-sm mr-3 border border-indigo-200">
                                    {{ strtoupper(substr($task->assignedUser->name, 0, 2)) }}
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $task->assignedUser->name }}</p>
                                    <p class="text-xs text-gray-500">Assigned User</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Time Tracking Card -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center mb-6 pb-3 border-b border-gray-200">
                        <i class="bi bi-clock-history text-indigo-600 mr-2"></i>
                        Time Tracking
                    </h3>
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <form action="{{ route('time-logs.start')}}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="task_id" value="{{$task->id}}"/>
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors border border-green-700">
                                    <i class="bi bi-play-fill mr-2"></i>
                                    Start Timer
                                </button>
                            </form>
                            <form action="{{ route('time-logs.stop') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="task_id" value="{{$task->id}}"/>
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors border border-red-700">
                                    <i class="bi bi-stop-fill mr-2"></i>
                                    Stop Timer
                                </button>
                            </form>
                        </div>
                        <div class="flex gap-3">
                            <!-- Export CSV -->
                            <form action="{{ route('time-logs.export','csv') }}" method="GET" class="flex-1">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                    <i class="bi bi-file-earmark-spreadsheet mr-2"></i>
                                    Export CSV
                                </button>
                            </form>
                        
                            <!-- Export PDF -->
                            <form action="{{ route('time-logs.export','pdf') }}" method="GET" class="flex-1">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                    <i class="bi bi-file-earmark-pdf mr-2"></i>
                                    Export PDF
                                </button>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Time Logs Table -->
    <div class="mt-6 bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center mb-6 pb-3 border-b border-gray-200">
                <i class="bi bi-clock-history text-indigo-600 mr-2"></i>
                Time Logs
            </h3>
            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Duration</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($task->timeLogs as $timeLog)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200">
                                    <div class="flex items-center">
                                        <span class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-sm mr-2 border border-indigo-200">
                                            {{ strtoupper(substr($timeLog->user->name, 0, 2)) }}
                                        </span>
                                        <span class="text-sm text-gray-900">{{ $timeLog->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-r border-gray-200">
                                    <i class="bi bi-calendar3 text-gray-400 mr-1"></i>
                                    {{ $timeLog->date_logged->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-r border-gray-200">
                                    <i class="bi bi-clock text-gray-400 mr-1"></i>
                                    {{ number_format($timeLog->hours_worked, 2) }} hours
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border
                                        @if($timeLog->status === 'approved') bg-green-100 text-green-800 border-green-200
                                        @elseif($timeLog->status === 'rejected') bg-red-100 text-red-800 border-red-200
                                        @else bg-yellow-100 text-yellow-800 border-yellow-200 @endif">
                                        <i class="bi bi-circle-fill mr-1 text-xs"></i>
                                        {{ ucfirst($timeLog->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($timeLog->status === 'pending')
                                        <form action="{{ route('time-logs.approve', $timeLog) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900 mr-3 border-b-2 border-transparent hover:border-green-600">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('time-logs.reject', $timeLog) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900 border-b-2 border-transparent hover:border-red-600">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    <i class="bi bi-clock text-gray-400 text-lg mr-2"></i>
                                    No time logs recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Messages Section -->
    <div class="mt-6 bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center mb-6 pb-3 border-b border-gray-200">
                <i class="bi bi-chat-dots text-indigo-600 mr-2"></i>
                Messages
            </h3>
            <div class="space-y-6">
                <form action="{{ route('messages.store') }}" method="POST" class="mb-6">
                    @csrf
                    <input type="hidden" name="task_id" value="{{ $task->id }}">
                    <input type="hidden" name="project_id" value="{{ $task->project->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::id()}}">
                
                    <div class="flex space-x-3">
                        <div class="flex-grow">
                            <textarea 
                                name="message" 
                                rows="2" 
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('message') border-red-500 @enderror"
                                placeholder="Type your message..."
                            >{{ old('message') }}</textarea>
                
                            {{-- Error Message --}}
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                
                        <div>
                            <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="bi bi-send mr-2"></i>
                                Send
                            </button>
                        </div>
                    </div>
                </form>
                

                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @foreach($task->messages()->latest()->get() as $message)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200"></span>
                                    @endif
                                    <div class="relative flex items-start space-x-3">
                                        <div class="relative">
                                            <span class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 border border-indigo-200">
                                                {{ strtoupper(substr($message->user->name, 0, 2)) }}
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 bg-gray-50 rounded-lg p-4 border border-gray-200">
                                            <div class="text-sm">
                                                <span class="font-medium text-gray-900">{{ $message->user->name }}</span>
                                                <span class="text-gray-500 ml-2">
                                                    <i class="bi bi-clock text-gray-400"></i>
                                                    {{ $message->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <div class="mt-2 text-sm text-gray-700">
                                                {{ $message->message }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection