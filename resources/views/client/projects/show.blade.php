<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $project->name }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('client.projects.documents', $project) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Documents
                </a>
                <a href="{{ route('client.projects.timeline', $project) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Timeline
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Project Overview -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Status</h3>
                            <span class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($project->status === 'completed') bg-green-100 text-green-800
                                @elseif($project->status === 'in_progress') bg-blue-100 text-blue-800
                                @elseif($project->status === 'on_hold') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Progress</h3>
                            <div class="mt-2">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $project->progress }}%"></div>
                                </div>
                                <span class="text-sm text-gray-500">{{ $project->progress }}% Complete</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Start Date</h3>
                            <p class="mt-2 text-sm text-gray-500">{{ $project->start_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">End Date</h3>
                            <p class="mt-2 text-sm text-gray-500">{{ $project->end_date->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Description -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Description</h3>
                    <div class="mt-4 prose max-w-none">
                        {{ $project->description }}
                    </div>
                </div>
            </div>

            <!-- Team Members -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Team Members</h3>
                    <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($project->teamMembers as $member)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <span class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                                            {{ strtoupper(substr($member->user->name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $member->user->name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $member->role }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Messages -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Recent Messages</h3>
                    <div class="mt-6 flow-root">
                        <ul role="list" class="-my-5 divide-y divide-gray-200">
                            @forelse($project->messages as $message)
                                <li class="py-5">
                                    <div class="flex space-x-3">
                                        <div class="flex-shrink-0">
                                            <span class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                                                {{ strtoupper(substr($message->user->name, 0, 2)) }}
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $message->user->name }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $message->created_at->diffForHumans() }}
                                            </p>
                                            <div class="mt-2 text-sm text-gray-700">
                                                {{ $message->message }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="py-5">
                                    <p class="text-sm text-gray-500 text-center">No recent messages</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>