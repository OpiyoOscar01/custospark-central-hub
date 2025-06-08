@extends('layouts.admin')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="mt-1 text-sm text-gray-500">Overview of your project management system.</p>
    </div>

  <!-- Stats Overview -->
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
    <!-- Projects Overview -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
        <div class="p-5">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="bg-indigo-100 text-indigo-600 rounded-xl p-3 border border-indigo-200">
                        <i class="bi bi-folder text-2xl"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Projects</dt>
                        <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $totalProjects }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
            <div class="text-sm">
                <a href="{{ route('projects.index') }}" class="inline-flex items-center font-medium text-indigo-600 hover:text-indigo-900">
                    View all projects
                    <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Team Members -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
        <div class="p-5">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="bg-blue-100 text-blue-600 rounded-xl p-3 border border-blue-200">
                        <i class="bi bi-person-check text-2xl"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Team Members</dt>
                        <dd class="mt-1 text-2xl font-bold text-gray-900">2</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
            <div class="text-sm">
                <a href="#" class="inline-flex items-center font-medium text-indigo-600 hover:text-indigo-900">
                    View all team members
                    <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Clients -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
        <div class="p-5">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="bg-green-100 text-green-600 rounded-xl p-3 border border-green-200">
                        <i class="bi bi-building text-2xl"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Clients</dt>
                        <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $totalClients }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
            <div class="text-sm">
                <a href="{{ route('clients.index') }}" class="inline-flex items-center font-medium text-indigo-600 hover:text-indigo-900">
                    View all clients
                    <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Users -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
        <div class="p-5">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="bg-yellow-100 text-yellow-600 rounded-xl p-3 border border-yellow-200">
                        <i class="bi bi-person-lines-fill text-2xl"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                        <dd class="mt-1 text-2xl font-bold text-gray-900">12</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
            <div class="text-sm">
                <a href="#" class="inline-flex items-center font-medium text-indigo-600 hover:text-indigo-900">
                    View all users
                    <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Careers -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
        <div class="p-5">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="bg-red-100 text-red-600 rounded-xl p-3 border border-red-200">
                        <i class="bi bi-briefcase text-2xl"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Open Careers</dt>
                        <dd class="mt-1 text-2xl font-bold text-gray-900">3</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
            <div class="text-sm">
                <a href="#" class="inline-flex items-center font-medium text-indigo-600 hover:text-indigo-900">
                    View career opportunities
                    <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
        <div class="p-5">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="bg-blue-100 text-blue-600 rounded-xl p-3 border border-blue-200">
                        <i class="bi bi-calendar-week text-2xl"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Calendar</dt>
                        <dd class="mt-1 text-2xl font-bold text-gray-900">View</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
            <div class="text-sm">
                <a href="{{route('calendar.index')}}" class="inline-flex items-center font-medium text-indigo-600 hover:text-indigo-900">
                    Go to calendar
                    <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
        <div class="p-5">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="bg-purple-100 text-purple-600 rounded-xl p-3 border border-purple-200">
                        <i class="bi bi-bell text-2xl"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Notifications</dt>
                        <dd class="mt-1 text-2xl font-bold text-gray-900">2</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
            <div class="text-sm">
                <a href="#" class="inline-flex items-center font-medium text-indigo-600 hover:text-indigo-900">
                    View all notifications
                    <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Finance -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
        <div class="p-5">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="bg-teal-100 text-teal-600 rounded-xl p-3 border border-teal-200">
                        <i class="bi bi-wallet2 text-2xl"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Finance</dt>
                        <dd class="mt-1 text-2xl font-bold text-gray-900">1</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
            <div class="text-sm">
                <a href="#" class="inline-flex items-center font-medium text-indigo-600 hover:text-indigo-900">
                    View finance details
                    <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- Growth Metrics -->
<div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
    <div class="p-5">
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0">
                <div class="bg-teal-100 text-teal-600 rounded-xl p-3 border border-teal-200">
                    <i class="bi bi-graph-up text-2xl"></i>
                </div>
            </div>
            <div class="flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Growth</dt>
                    <dd class="mt-1 text-2xl font-bold text-gray-900">+20%</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
        <div class="text-sm">
            <a href="#" class="inline-flex items-center font-medium text-indigo-600 hover:text-indigo-900">
                View detailed growth metrics
                <i class="bi bi-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</div>

</div>


    <!-- Recent Projects -->
    <div class="mt-8">
        <div class="bg-white shadow-lg rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="bg-indigo-100 p-2 rounded-lg border border-indigo-200">
                        <i class="bi bi-folder text-indigo-600 text-xl"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900">Recent Projects</h2>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentProjects as $project)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $project->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $project->client->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($project->status === 'completed') bg-green-100 text-green-800
                                    @elseif($project->status === 'in_progress') bg-blue-100 text-blue-800
                                    @elseif($project->status === 'on_hold') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ str_replace('_', ' ', ucfirst($project->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $project->progress }}%"></div>
                                    </div>
                                    <span class="ml-2 text-xs text-gray-500">{{ $project->progress }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-900">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Upcoming Tasks -->
    <div class="mt-8">
        <div class="bg-white shadow-lg rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="bg-purple-100 p-2 rounded-lg border border-purple-200">
                        <i class="bi bi-list-check text-purple-600 text-xl"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900">Upcoming Tasks</h2>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($upcomingTasks as $task)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $task->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $task->project->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $task->assignedUser->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $task->due_date->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($task->priority === 'urgent') bg-red-100 text-red-800
                                    @elseif($task->priority === 'high') bg-orange-100 text-orange-800
                                    @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('tasks.show', $task) }}" class="text-indigo-600 hover:text-indigo-900">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection