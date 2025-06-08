@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('milestones.index') }}" class="hover:text-gray-700">Milestones</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Create New</span>
    </nav>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-purple-100 p-2 rounded-lg border border-purple-200">
                        <i class="bi bi-flag-fill text-purple-600 text-xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">Create Milestone</h1>
                </div>
                <a href="{{ route('milestones.index') }}" 
                   class="text-gray-500 hover:text-gray-700">
                    <i class="bi bi-x-lg text-xl"></i>
                </a>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('milestones.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Project Selection -->
                <div class="space-y-2">
                    <label for="project_id" class="flex items-center text-sm font-medium text-gray-700">
                        <i class="bi bi-folder2 mr-2 text-gray-400"></i>
                        Project
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="relative">
                        <select id="project_id" 
                                name="project_id" 
                                required
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 pl-3 pr-10">
                            <option value="">Select a project</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <i class="bi bi-chevron-down text-sm"></i>
                        </div>
                    </div>
                    @error('project_id')
                        <p class="text-sm text-red-600 mt-1 flex items-center">
                            <i class="bi bi-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Title -->
                <div class="space-y-2">
                    <label for="title" class="flex items-center text-sm font-medium text-gray-700">
                        <i class="bi bi-type mr-2 text-gray-400"></i>
                        Title
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input id="title" 
                           type="text" 
                           name="title" 
                           value="{{ old('title') }}" 
                           required 
                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50"
                           placeholder="Enter milestone title">
                    @error('title')
                        <p class="text-sm text-red-600 mt-1 flex items-center">
                            <i class="bi bi-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label for="description" class="flex items-center text-sm font-medium text-gray-700">
                        <i class="bi bi-text-paragraph mr-2 text-gray-400"></i>
                        Description
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4" 
                              class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50"
                              placeholder="Enter milestone description">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-600 mt-1 flex items-center">
                            <i class="bi bi-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Due Date -->
                <div class="space-y-2">
                    <label for="due_date" class="flex items-center text-sm font-medium text-gray-700">
                        <i class="bi bi-calendar-event mr-2 text-gray-400"></i>
                        Due Date
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="relative">
                        <input id="due_date" 
                               type="date" 
                               name="due_date" 
                               value="{{ old('due_date') }}" 
                               required 
                               min="{{ date('Y-m-d') }}"
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    </div>
                    @error('due_date')
                        <p class="text-sm text-red-600 mt-1 flex items-center">
                            <i class="bi bi-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <label for="status" class="flex items-center text-sm font-medium text-gray-700">
                        <i class="bi bi-check-circle mr-2 text-gray-400"></i>
                        Status
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="relative">
                        <select id="status" 
                                name="status" 
                                required
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                                <i class="bi bi-clock-history"></i> Pending
                            </option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                                <i class="bi bi-check-circle-fill"></i> Completed
                            </option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <i class="bi bi-chevron-down text-sm"></i>
                        </div>
                    </div>
                    @error('status')
                        <p class="text-sm text-red-600 mt-1 flex items-center">
                            <i class="bi bi-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                    <a href="{{ url()->previous()}}" 
                       class="inline-flex items-center px-4 py-2 bg-white text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all border border-gray-300">
                        <i class="bi bi-x-lg mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all border border-purple-700 shadow-sm">
                        <i class="bi bi-plus-lg mr-2"></i>
                        Create Milestone
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection