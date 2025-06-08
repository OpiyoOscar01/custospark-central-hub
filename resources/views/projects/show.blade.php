@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Project Overview -->
    <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                    <i class="bi bi-kanban-fill text-blue-600 text-xl"></i>
                </div>
                Project Overview
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('projects.edit', $project) }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-all border border-indigo-700 shadow-sm">
                    <i class="bi bi-pencil-square mr-2"></i>
                    Edit Project
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Status -->
            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 hover:shadow-md transition-all">
                <div class="flex items-center gap-2 text-sm text-gray-600 font-medium mb-3">
                    <i class="bi bi-check-circle-fill text-green-500"></i>
                    Status
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border
                    @if($project->status === 'completed') bg-green-100 text-green-800 border-green-200
                    @elseif($project->status === 'in_progress') bg-blue-100 text-blue-800 border-blue-200
                    @elseif($project->status === 'on_hold') bg-yellow-100 text-yellow-800 border-yellow-200
                    @else bg-gray-100 text-gray-800 border-gray-200 @endif">
                    <i class="bi bi-circle-fill mr-1 text-xs"></i>
                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                </span>
            </div>

            <!-- Priority -->
            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 hover:shadow-md transition-all">
                <div class="flex items-center gap-2 text-sm text-gray-600 font-medium mb-3">
                    <i class="bi bi-flag-fill text-red-500"></i>
                    Priority
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border
                    @if($project->priority === 'urgent') bg-red-100 text-red-800 border-red-200
                    @elseif($project->priority === 'high') bg-orange-100 text-orange-800 border-orange-200
                    @elseif($project->priority === 'medium') bg-yellow-100 text-yellow-800 border-yellow-200
                    @else bg-green-100 text-green-800 border-green-200 @endif">
                    <i class="bi bi-circle-fill mr-1 text-xs"></i>
                    {{ ucfirst($project->priority) }}
                </span>
            </div>

            <!-- Budget -->
            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 hover:shadow-md transition-all">
                <div class="flex items-center gap-2 text-sm text-gray-600 font-medium mb-3">
                    <i class="bi bi-cash text-emerald-500"></i>
                    Budget
                </div>
                <p class="text-xl font-bold text-gray-900">${{ number_format($project->budget, 2) }}</p>
            </div>

            <!-- Progress -->
            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 hover:shadow-md transition-all">
                <div class="flex items-center gap-2 text-sm text-gray-600 font-medium mb-3">
                    <i class="bi bi-graph-up text-blue-500"></i>
                    Progress
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 border border-gray-300">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                         style="width: {{ $project->progress }}%"></div>
                </div>
                <p class="mt-2 text-sm text-gray-600">
                    <i class="bi bi-check2-circle mr-1"></i>
                    {{ $project->progress }}% Complete
                </p>
            </div>
        </div>

        <!-- Meta Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-6 bg-gray-50 rounded-xl border border-gray-200 mb-8">
            <div class="space-y-4">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Client</h4>
                    <p class="text-sm font-medium text-gray-900 flex items-center gap-2">
                        <i class="bi bi-person text-gray-400"></i>
                        {{ $project->client->name }}
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Company</h4>
                    <p class="text-sm font-medium text-gray-900 flex items-center gap-2">
                        <i class="bi bi-building text-gray-400"></i>
                        {{ $project->client->company_name }}
                    </p>
                </div>
            </div>
            <div class="space-y-4">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Start Date</h4>
                    <p class="text-sm font-medium text-gray-900 flex items-center gap-2">
                        <i class="bi bi-calendar-event text-gray-400"></i>
                        {{ $project->start_date->format('M d, Y') }}
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-1">End Date</h4>
                    <p class="text-sm font-medium text-gray-900 flex items-center gap-2">
                        <i class="bi bi-calendar-event text-gray-400"></i>
                        {{ $project->end_date->format('M d, Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="p-6 bg-gray-50 rounded-xl border border-gray-200">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <i class="bi bi-info-circle text-indigo-600"></i>
                Description
            </h4>
            <div class="text-sm text-gray-700 leading-relaxed">
                {{ $project->description }}
            </div>
        </div>
    </div>

    <!-- Team Members -->
    <div class="mt-8 bg-white shadow-lg rounded-xl p-6 border border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <div class="bg-indigo-100 p-2 rounded-lg border border-indigo-200">
                    <i class="bi bi-people-fill text-indigo-600 text-xl"></i>
                </div>
                Team Members
            </h2>
            <a href="{{ route('team-members.create', $project->id) }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-all border border-indigo-700 shadow-sm">
                <i class="bi bi-person-plus-fill mr-2"></i>
                Add Member
            </a>
        </div>

        @if($project->teamMembers->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($project->teamMembers as $member)
                    <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 hover:shadow-md transition-all">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm border border-indigo-200">
                                {{ strtoupper(substr($member->user->name, 0, 2)) }}
                            </div>
                            <div>
                                <h4 class="text-md font-semibold text-gray-900">{{ $member->user->name }}</h4>
                                <p class="text-sm text-gray-600 flex items-center gap-1">
                                    <i class="bi bi-person-badge text-gray-400"></i>
                                    {{ ucfirst($member->role) }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                    <i class="bi bi-calendar2-week text-gray-400"></i>
                                    Since {{ $member->assigned_date->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 bg-gray-50 rounded-xl border border-gray-200">
                <i class="bi bi-people text-4xl text-gray-400 mb-3"></i>
                <p class="text-gray-500 text-sm">No team members assigned yet.</p>
            </div>
        @endif
    </div>

    <!-- Tasks -->
    <div class="mt-8 bg-white shadow-lg rounded-xl p-6 border border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                    <i class="bi bi-list-task text-blue-600 text-xl"></i>
                </div>
                Tasks
            </h2>
            <a href="{{ route('tasks.create', ['project' => $project->id]) }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-all border border-blue-700 shadow-sm">
                <i class="bi bi-plus-lg mr-2"></i>
                Add Task
            </a>
        </div>

        @if($project->tasks->count())
            <div class="overflow-x-auto border border-gray-200 rounded-xl">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Assigned To</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Priority</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Due Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Progress</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($project->tasks as $task)
                            <tr class="hover:bg-gray-50 transition-all">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 border-r border-gray-200">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 border-r border-gray-200">
                                    {{ $task->title }}
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
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('tasks.show', $task) }}"
                                       class="text-blue-600 hover:text-blue-800 inline-flex items-center gap-1">
                                        <i class="bi bi-eye-fill"></i>
                                        <span>View</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8 bg-gray-50 rounded-xl border border-gray-200">
                <i class="bi bi-list-task text-4xl text-gray-400 mb-3"></i>
                <p class="text-gray-500 text-sm">No tasks available for this project.</p>
            </div>
        @endif
    </div>

    <!-- Milestones -->
    <div class="mt-8 bg-white shadow-lg rounded-xl p-6 border border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <div class="bg-purple-100 p-2 rounded-lg border border-purple-200">
                    <i class="bi bi-flag-fill text-purple-600 text-xl"></i>
                </div>
                Milestones
            </h2>
            <a href="{{ route('milestones.create', ['project' => $project->id]) }}"
               class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition-all border border-purple-700 shadow-sm">
                <i class="bi bi-plus-lg mr-2"></i>
                Add Milestone
            </a>
        </div>

        @if($project->milestones->count())
            <div class="overflow-x-auto border border-gray-200 rounded-xl">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Due Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($project->milestones as $milestone)
                            <tr class="hover:bg-gray-50 transition-all">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 border-r border-gray-200">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 border-r border-gray-200">
                                    {{ $milestone->title }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 border-r border-gray-200">
                                    {{ $milestone->description }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 border-r border-gray-200">
                                    <i class="bi bi-calendar3 text-gray-400 mr-1"></i>
                                    {{ $milestone->due_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 border-r border-gray-200">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border
                                        @if($milestone->status === 'completed') bg-green-100 text-green-800 border-green-200
                                        @else bg-yellow-100 text-yellow-800 border-yellow-200 @endif">
                                        <i class="bi bi-circle-fill mr-1 text-[8px]"></i>
                                        {{ ucfirst($milestone->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center space-x-3">
                                        <a href="{{ route('milestones.show', $milestone) }}"
                                           class="text-blue-600 hover:text-blue-800 inline-flex items-center gap-1">
                                            <i class="bi bi-eye-fill"></i>
                                            <span>View</span>
                                        </a>
                                        <a href="{{ route('milestones.edit', $milestone) }}"
                                           class="text-indigo-600 hover:text-indigo-800 inline-flex items-center gap-1">
                                            <i class="bi bi-pencil-fill"></i>
                                            <span>Edit</span>
                                        </a>
                                        <form action="{{ route('milestones.destroy', $milestone) }}" method="POST" class="inline-block"
                                              onsubmit="return confirm('Are you sure you want to delete this milestone?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 inline-flex items-center gap-1">
                                                <i class="bi bi-trash-fill"></i>
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8 bg-gray-50 rounded-xl border border-gray-200">
                <i class="bi bi-flag text-4xl text-gray-400 mb-3"></i>
                <p class="text-gray-500 text-sm">No milestones found for this project.</p>
            </div>
        @endif
    </div>

    <!-- Documents -->
    <div class="mt-8 bg-white shadow-lg rounded-xl p-6 border border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                    <div class="bg-green-100 p-2 rounded-lg border border-green-200">
                        <i class="bi bi-folder-fill text-green-600 text-xl"></i>
                    </div>
                    Project Documents
                </h2>
                <a href="{{ route('documents.index', ['project' => $project->id]) }}"
                   class="text-sm text-indigo-600 hover:text-indigo-800 mt-2 inline-flex items-center gap-1">
                    <span>View All Documents</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <a href="{{ route('documents.create', ['project' => $project->id]) }}"
               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-all border border-green-700 shadow-sm">
                <i class="bi bi-cloud-upload-fill mr-2"></i>
                Upload Document
            </a>
        </div>

        @if($project->documents->isEmpty())
            <div class="text-center py-8 bg-gray-50 rounded-xl border border-gray-200">
                <i class="bi bi-folder text-4xl text-gray-400 mb-3"></i>
                <p class="text-gray-500 text-sm">No documents uploaded yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($project->documents as $document)
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 hover:shadow-md transition-all">
                        <div class="flex items-start gap-4">
                            <div class="bg-white p-3 rounded-lg border border-gray-200">
                                <i class="bi bi-file-earmark-text-fill text-gray-600 text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-gray-900 truncate">
                                    {{ Str::limit($document->file_name, 35) }}
                                </h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    Uploaded by <span class="font-medium">{{ $document->uploader->name }}</span>
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    <i class="bi bi-clock text-gray-400"></i>
                                    {{ $document->created_at->format('M d, Y h:i A') }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end gap-3">
                            <a href="{{ route('documents.download', $document) }}"
                               class="text-indigo-600 hover:text-indigo-800 text-sm font-medium inline-flex items-center gap-1">
                                <i class="bi bi-download"></i>
                                <span>Download</span>
                            </a>
                            <form action="{{ route('documents.destroy', $document) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this document?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-800 text-sm font-medium inline-flex items-center gap-1">
                                    <i class="bi bi-trash-fill"></i>
                                    <span>Delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Messages -->
    <div class="mt-8 bg-white shadow-lg rounded-xl p-6 border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2 mb-6">
            <div class="bg-pink-100 p-2 rounded-lg border border-pink-200">
                <i class="bi bi-chat-dots-fill text-pink-600 text-xl"></i>
            </div>
            Messages
        </h2>

        <form action="{{ route('messages.store') }}" method="POST" class="mb-8">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}">
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        
            <div class="flex items-start gap-4">
                <div class="flex-grow">
                    <textarea name="message" rows="2"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 resize-none"
                        placeholder="Type your message..." required></textarea>
                </div>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-all border border-indigo-700 shadow-sm">
                    <i class="bi bi-send-fill mr-2"></i>
                    Send
                </button>
            </div>
            <div class="mb-4">
                <label for="task_id" class="block text-sm font-medium text-gray-700 mb-1">Select Task</label>
                <select name="task_id" id="task_id" required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">-- Choose a Task --</option>
                    @foreach($project->tasks as $task)
                        <option value="{{ $task->id }}">{{ $task->title }}</option>
                    @endforeach
                </select>
            </div>
        </form>
        

        <div class="space-y-6">
            @foreach($project->messages()->latest()->get() as $message)
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <span class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 border border-indigo-200">
                            {{ strtoupper(substr($message->user->name, 0, 2)) }}
                        </span>
                    </div>
                    <div class="flex-grow">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-medium text-gray-900">{{ $message->user->name }}</span>
                                <span class="text-sm text-gray-500">
                                    <i class="bi bi-clock text-gray-400"></i>
                                    {{ $message->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-gray-700 text-sm">{{ $message->message }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection