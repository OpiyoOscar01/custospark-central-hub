@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                    <i class="bi bi-person-plus-fill text-blue-600 text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Add Team Member</h1>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('team-members.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">

                <!-- Team Member Selection -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="bi bi-people-fill text-blue-600"></i>
                        Member Details
                    </h2>

                    <div class="space-y-6">
                        <!-- User Selection -->
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-person text-gray-400 mr-1"></i>
                                Select Team Member
                            </label>
                            <select id="user_id" 
                                    name="user_id" 
                                    required 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Choose a team member...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-person-badge text-gray-400 mr-1"></i>
                                Role
                            </label>
                            <input id="role" 
                                   type="text" 
                                   name="role" 
                                   value="{{ old('role') }}" 
                                   required 
                                   maxlength="255" 
                                   placeholder="e.g., Developer, Designer, Project Manager"
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                            @error('role')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Assignment Date -->
                        <div>
                            <label for="assigned_date" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-calendar-date text-gray-400 mr-1"></i>
                                Assignment Date
                            </label>
                            <input id="assigned_date" 
                                   type="date" 
                                   name="assigned_date" 
                                   value="{{ old('assigned_date') }}" 
                                   required 
                                   max="{{ now()->toDateString() }}"
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                            @error('assigned_date')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-4">
                    <a href="{{ route('projects.show', $project->id) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="bi bi-x-lg mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="bi bi-plus-lg mr-2"></i>
                        Add Team Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection