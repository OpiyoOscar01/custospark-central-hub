@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('jobs.index') }}" class="hover:text-gray-700">Jobs</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Create Job</span>
    </nav>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                    <i class="bi bi-briefcase text-blue-600 text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Create New Job Position</h1>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('jobs.store') }}" method="POST" class="space-y-8">
                @csrf

                <!-- Basic Information -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="bi bi-info-circle-fill text-blue-600"></i>
                        Basic Information
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Job Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-type text-gray-400 mr-1"></i>
                                Job Title
                            </label>
                            <input type="text" name="title" id="title" 
                                   value="{{ old('title') }}" 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   placeholder="Enter job title"
                                   required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Department -->
                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-building text-gray-400 mr-1"></i>
                                Department
                            </label>
                            <input type="text" name="department" id="department" 
                                   value="{{ old('department') }}" 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   placeholder="Enter department name"
                                   required>
                            @error('department')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-text-paragraph text-gray-400 mr-1"></i>
                                Job Description
                            </label>
                            <textarea id="description" 
                                    name="description" 
                                    rows="4" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Enter detailed job description"
                                    required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Requirements and Responsibilities -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="bi bi-list-check text-blue-600"></i>
                        Requirements and Responsibilities
                    </h2>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Requirements -->
                        <div>
                            <label for="requirements" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-check-square text-gray-400 mr-1"></i>
                                Requirements
                            </label>
                            <textarea id="requirements" 
                                    name="requirements" 
                                    rows="4" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Enter job requirements"
                                    required>{{ old('requirements') }}</textarea>
                            @error('requirements')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Responsibilities -->
                        <div>
                            <label for="responsibilities" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-list-task text-gray-400 mr-1"></i>
                                Responsibilities
                            </label>
                            <textarea id="responsibilities" 
                                    name="responsibilities" 
                                    rows="4" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Enter job responsibilities"
                                    required>{{ old('responsibilities') }}</textarea>
                            @error('responsibilities')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Job Details -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="bi bi-gear-fill text-blue-600"></i>
                        Job Details
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-geo-alt text-gray-400 mr-1"></i>
                                Location
                            </label>
                            <input type="text" name="location" id="location" 
                                   value="{{ old('location') }}" 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   placeholder="Enter job location"
                                   required>
                            @error('location')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-briefcase text-gray-400 mr-1"></i>
                                Employment Type
                            </label>
                            <select id="type" 
                                    name="type" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                                <option value="full-time" {{ old('type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                <option value="part-time" {{ old('type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                <option value="contract" {{ old('type') == 'contract' ? 'selected' : '' }}>Contract</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Experience Level -->
                        <div>
                            <label for="experience_level" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-star text-gray-400 mr-1"></i>
                                Experience Level
                            </label>
                            <input type="text" name="experience_level" id="experience_level" 
                                   value="{{ old('experience_level') }}" 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   placeholder="e.g., Entry Level, Senior, etc."
                                   required>
                            @error('experience_level')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Positions Available -->
                        <div>
                            <label for="positions_available" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-people text-gray-400 mr-1"></i>
                                Positions Available
                            </label>
                            <input type="number" name="positions_available" id="positions_available" 
                                   value="{{ old('positions_available', 1) }}" 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   min="1"
                                   required>
                            @error('positions_available')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Salary Information -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="bi bi-currency-dollar text-blue-600"></i>
                        Salary Information
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Minimum Salary -->
                        <div>
                            <label for="salary_min" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-currency-dollar text-gray-400 mr-1"></i>
                                Minimum Salary
                            </label>
                            <input type="number" name="salary_min" id="salary_min" 
                                   value="{{ old('salary_min') }}" 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   step="0.01"
                                   min="0">
                            @error('salary_min')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Maximum Salary -->
                        <div>
                            <label for="salary_max" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-currency-dollar text-gray-400 mr-1"></i>
                                Maximum Salary
                            </label>
                            <input type="number" name="salary_max" id="salary_max" 
                                   value="{{ old('salary_max') }}" 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   step="0.01"
                                   min="0">
                            @error('salary_max')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Currency -->
                        <div>
                            <label for="salary_currency" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-cash text-gray-400 mr-1"></i>
                                Currency
                            </label>
                            <select id="salary_currency" 
                                    name="salary_currency" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="USD" {{ old('salary_currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                <option value="UGX" {{ old('salary_currency') == 'UGX' ? 'selected' : '' }}>UGX</option>
                                <option value="EUR" {{ old('salary_currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                <option value="GBP" {{ old('salary_currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                            </select>
                            @error('salary_currency')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Options -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="bi bi-sliders text-blue-600"></i>
                        Additional Options
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Remote Work -->
                        <div>
                        <!-- Hidden field ensures unchecked = false -->
                        <input type="hidden" name="is_remote" value="0">

                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="is_remote" 
                                value="1"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                                {{ old('is_remote') ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">This is a remote position</span>
                        </label>

                            @error('is_remote')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Deadline -->
                        <div>
                            <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-calendar text-gray-400 mr-1"></i>
                                Application Deadline
                            </label>
                            <input type="datetime-local" 
                                   id="deadline" 
                                   name="deadline" 
                                   value="{{ old('deadline') }}" 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('deadline')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-toggle-on text-gray-400 mr-1"></i>
                                Status
                            </label>
                            <select id="status" 
                                    name="status" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('jobs.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="bi bi-x-lg mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="bi bi-check-lg mr-2"></i>
                        Create Job
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection