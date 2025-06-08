@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('milestones.index') }}" class="hover:text-gray-700">Milestones</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">{{ $milestone->title }}</span>
    </nav>

    <!-- Header -->
    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="bg-purple-100 p-2 rounded-lg border border-purple-200">
                        <i class="bi bi-flag-fill text-purple-600 text-xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $milestone->title }}</h1>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('milestones.edit', $milestone) }}" 
                       class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg text-sm font-medium hover:bg-yellow-700 transition-all border border-yellow-700 shadow-sm">
                        <i class="bi bi-pencil-fill mr-2"></i>
                        Edit
                    </a>
                    <form action="{{ route('milestones.destroy', $milestone) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Are you sure you want to delete this milestone? This action cannot be undone.')"
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-all border border-red-700 shadow-sm">
                            <i class="bi bi-trash-fill mr-2"></i>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="p-6">
            <!-- Milestone Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="bi bi-info-circle text-gray-500"></i>
                            Milestone Details
                        </h2>
                        <dl class="grid grid-cols-1 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <dt class="text-sm font-medium text-gray-500">Project</dt>
                                <dd class="mt-1 text-sm text-gray-900 flex items-center gap-2">
                                    <i class="bi bi-folder2 text-gray-400"></i>
                                    {{ $milestone->project->name }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <dt class="text-sm font-medium text-gray-500">Description</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $milestone->description ?: 'No description provided.' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="bi bi-clock-history text-gray-500"></i>
                            Status & Timeline
                        </h2>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border
                                        @if($milestone->status === 'completed') 
                                            bg-green-100 text-green-800 border-green-200
                                        @else 
                                            bg-yellow-100 text-yellow-800 border-yellow-200 
                                        @endif">
                                        <i class="bi bi-circle-fill mr-2 text-xs"></i>
                                        {{ ucfirst($milestone->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <dt class="text-sm font-medium text-gray-500">Due Date</dt>
                                <dd class="mt-1 text-sm">
                                    <div class="flex items-center gap-2 text-gray-900">
                                        <i class="bi bi-calendar-event text-gray-400"></i>
                                        {{ $milestone->due_date->format('M d, Y') }}
                                    </div>
                                    <p class="mt-2 text-sm @if($milestone->due_date->isPast()) text-red-600 @else text-gray-500 @endif">
                                        <i class="bi bi-clock mr-1"></i>
                                        @if($milestone->due_date->isPast())
                                            Overdue by {{ $milestone->due_date->diffForHumans() }}
                                        @else
                                            Due {{ $milestone->due_date->diffForHumans() }}
                                        @endif
                                    </p>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Related Tasks -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="bi bi-list-task text-gray-500"></i>
                        Related Tasks
                    </h2>
                    <a href="{{ route('tasks.create', ['project' => $milestone->project->id]) }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-all border border-indigo-700 shadow-sm">
                        <i class="bi bi-plus-lg mr-2"></i>
                        Add Task
                    </a>
                </div>

                <div class="bg-white overflow-hidden border border-gray-200 rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Task</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Assigned To</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Due Date</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($milestone->project->tasks()->where('due_date', '<=', $milestone->due_date)->get() as $task)
                                    <tr class="hover:bg-gray-50 transition-all">
                                        <td class="px-6 py-4 border-r border-gray-200">
                                            <div class="text-sm font-medium text-gray-900">{{ $task->title }}</div>
                                        </td>
                                        <td class="px-6 py-4 border-r border-gray-200">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-sm border border-indigo-200">
                                                    {{ strtoupper(substr($task->assignedUser->name, 0, 2)) }}
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $task->assignedUser->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 border-r border-gray-200">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border
                                                @if($task->status === 'completed') bg-green-100 text-green-800 border-green-200
                                                @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800 border-blue-200
                                                @elseif($task->status === 'on_hold') bg-yellow-100 text-yellow-800 border-yellow-200
                                                @else bg-gray-100 text-gray-800 border-gray-200 @endif">
                                                <i class="bi bi-circle-fill mr-1 text-[8px]"></i>
                                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-r border-gray-200">
                                            <i class="bi bi-calendar3 text-gray-400 mr-1"></i>
                                            {{ $task->due_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            <a href="{{ route('tasks.show', $task) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 inline-flex items-center gap-1">
                                                <i class="bi bi-eye-fill"></i>
                                                <span>View</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <i class="bi bi-list-task text-4xl text-gray-400 mb-3"></i>
                                                <p>No related tasks found for this milestone.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection