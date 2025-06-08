@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My Tasks</h1>
            <p class="mt-1 text-sm text-gray-500">A list of all your assigned tasks across different projects.</p>
        </div>
        <div>
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="bi bi-plus-lg mr-2"></i>
                New Task
            </a>
        </div>
    </div>

    <!-- Tasks List -->
    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-6">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($tasks as $task)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="whitespace-nowrap py-4 pl-6 pr-3">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 flex-shrink-0 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <i class="bi bi-list-task text-indigo-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">{{ $task->title }}</div>
                                        @if($task->description)
                                            <div class="text-gray-500 text-sm truncate max-w-xs">
                                                {{ Str::limit($task->description, 50) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                <div class="text-sm text-gray-900">{{ $task->project->name }}</div>
                                <div class="text-sm text-gray-500">{{ $task->project->client->company_name }}</div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                <div class="text-sm text-gray-900">{{ $task->due_date->format('M d, Y') }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ $task->due_date->diffForHumans() }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium 
                                    @if($task->priority === 'urgent') bg-red-100 text-red-800
                                    @elseif($task->priority === 'high') bg-orange-100 text-orange-800
                                    @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800
                                    @else bg-green-100 text-green-800 @endif">
                                    <i class="bi bi-flag-fill mr-1 text-xs"></i>
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium 
                                    @if($task->status === 'completed') bg-green-100 text-green-800
                                    @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                                    @elseif($task->status === 'on_hold') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    <i class="bi bi-circle-fill mr-1 text-xs"></i>
                                    {{ str_replace('_', ' ', ucfirst($task->status)) }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                <div class="flex items-center">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $task->progress }}%"></div>
                                    </div>
                                    <span class="ml-2 text-xs text-gray-500">{{ $task->progress }}%</span>
                                </div>
                            </td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('tasks.show', $task) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 flex items-center">
                                        <i class="bi bi-eye mr-1"></i>
                                        View
                                    </a>
                                    <a href="{{ route('tasks.edit', $task) }}" 
                                       class="text-gray-600 hover:text-gray-900 flex items-center">
                                        <i class="bi bi-pencil mr-1"></i>
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                        <i class="bi bi-clipboard text-2xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-sm font-medium text-gray-900">No Tasks Found</h3>
                                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new task.</p>
                                    <div class="mt-4">
                                        <a href="{{ route('tasks.create') }}" 
                                           class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-400">
                                            <i class="bi bi-plus-lg mr-2"></i>
                                            New Task
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- @if($tasks->hasPages())
            <div class="border-t border-gray-200 px-6 py-4">
                {{ $tasks->links() }}
            </div>
        @endif --}}
    </div>
</div>
@endsection