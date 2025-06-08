@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                        <i class="bi bi-list-task text-blue-600 text-xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">Tasks</h1>
                </div>
                <a href="{{ route('tasks.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-all border border-blue-700 shadow-sm">
                    <i class="bi bi-plus-lg mr-2"></i>
                    Create Task
                </a>
            </div>
        </div>

        <div class="p-6">
            @if($tasks->count())
                <div class="overflow-x-auto border border-gray-200 rounded-xl">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Project</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Assigned To</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Priority</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Due Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Progress</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tasks as $task)
                                <tr class="hover:bg-gray-50 transition-all">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 border-r border-gray-200">
                                        {{ $task->title }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 border-r border-gray-200">
                                        {{ $task->project->name }}
                                    </td>
                                    <td class="px-6 py-4 border-r border-gray-200">
                                        <div class="flex items-center">
                                            <span class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-sm mr-2 border border-indigo-200">
                                                {{ strtoupper(substr($task->assignedUser->name, 0, 2)) }}
                                            </span>
                                            <span class="text-sm text-gray-900">{{ $task->assignedUser->name }}</span>
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
                                    <td class="px-6 py-4 border-r border-gray-200">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border
                                            @if($task->priority === 'urgent') bg-red-100 text-red-800 border-red-200
                                            @elseif($task->priority === 'high') bg-orange-100 text-orange-800 border-orange-200
                                            @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800 border-yellow-200
                                            @else bg-green-100 text-green-800 border-green-200 @endif">
                                            <i class="bi bi-flag-fill mr-1 text-[8px]"></i>
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 border-r border-gray-200">
                                        <i class="bi bi-calendar3 text-gray-400 mr-1"></i>
                                        {{ $task->due_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 border-r border-gray-200">
                                        <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                                                 style="width: {{ $task->progress }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $task->progress }}%</span>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-3">
                                        <a href="{{ route('tasks.show', $task) }}"
                                           class="text-blue-600 hover:text-blue-800 inline-flex items-center gap-1">
                                            <i class="bi bi-eye-fill"></i>
                                            <span>View</span>
                                        </a>
                                        <a href="{{ route('tasks.edit', $task) }}"
                                           class="text-indigo-600 hover:text-indigo-800 inline-flex items-center gap-1">
                                            <i class="bi bi-pencil-fill"></i>
                                            <span>Edit</span>
                                        </a>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 inline-flex items-center gap-1"
                                                    onclick="return confirm('Are you sure you want to delete this task?')">
                                                <i class="bi bi-trash-fill"></i>
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 bg-gray-50 rounded-xl border border-gray-200">
                    <i class="bi bi-list-task text-4xl text-gray-400 mb-3"></i>
                    <p class="text-gray-500 text-sm">No tasks available.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection