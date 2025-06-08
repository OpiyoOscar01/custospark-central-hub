@extends('layouts.employee')

@section('content')
<div class="py-1 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-2 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('apps.index') }}" class="hover:text-gray-700">Apps</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Edit</span>
    </nav>

    <!-- Form Container -->
    <div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                    <i class="bi bi-pencil-square text-blue-600 text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Edit App</h1>
            </div>
            <a href="{{ url()->previous() }}" class="text-blue-500 hover:text-blue-700">
                <i class="bi bi-x-lg text-xl"></i>
            </a>
        </div>

        <!-- Form Body -->
        <div class="p-8">
          <form action="{{ route('apps.update', $app->slug) }}" method="POST" class="">

                @csrf
                @method('PUT')

                <fieldset class="space-y-10">
                    <legend class="sr-only">Edit App Form</legend>

                    <!-- App Details -->
                    <fieldset class="space-y-4">
                        <legend class="text-lg font-semibold text-blue-700 border-l-4 border-blue-500 pl-3">
                            <i class="bi bi-info-circle-fill mr-2"></i>App Details
                        </legend>
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- App Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="bi bi-card-text mr-1 text-gray-500"></i> App Name <span class="text-red-500">*</span>
                                </label>
                                <input id="name" name="name" type="text" value="{{ old('name', $app->name) }}" required
                                    class="w-full rounded-lg border border-gray-300 shadow-sm focus:border-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    placeholder="e.g. HR System">
                                @error('name')
                                    <p class="text-sm text-red-600 mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="tagline" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="bi bi-type mr-1 text-gray-500"></i> App tagline <span class="text-red-500">*</span>
                                </label>
                                <input id="tagline" name="tagline" type="text" value="{{ old('name', $app->tagline) }}" required
                                    class="w-full rounded-lg border border-gray-300 shadow-sm focus:border-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    placeholder="">
                                @error('tagline')
                                    <p class="text-sm text-red-600 mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Slug -->
                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="bi bi-link-45deg mr-1 text-gray-500"></i> Slug <span class="text-red-500">*</span>
                                </label>
                                <input id="slug" name="slug" type="text" value="{{ old('slug', $app->slug) }}" required
                                    class="w-full rounded-lg border border-gray-300 shadow-sm focus:border-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    placeholder="e.g. hr-system">
                                @error('slug')
                                    <p class="text-sm text-red-600 mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    <!-- URLs -->
                    <fieldset class="space-y-4">
                        <legend class="text-lg font-semibold text-blue-700 border-l-4 border-blue-500 pl-3">
                            <i class="bi bi-globe2 mr-2"></i> URLs
                        </legend>
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Base URL -->
                            <div>
                                <label for="base_url" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="bi bi-link-45deg mr-1 text-gray-500"></i> Base URL <span class="text-red-500">*</span>
                                </label>
                                <input id="base_url" name="base_url" type="url" value="{{ old('base_url', $app->base_url) }}" required
                                    class="w-full rounded-lg border border-gray-300 shadow-sm focus:border-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    placeholder="https://hr.yourdomain.com">
                                @error('base_url')
                                    <p class="text-sm text-red-600 mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Icon URL -->
                            <div>
                                <label for="icon_url" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="bi bi-image mr-1 text-gray-500"></i> Icon URL
                                </label>
                                <input id="icon_url" name="icon_url" type="url" value="{{ old('icon_url', $app->icon_url) }}"
                                    class="w-full rounded-lg border border-gray-300 shadow-sm focus:border-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    placeholder="https://cdn.domain.com/icons/hr.svg">
                                @error('icon_url')
                                    <p class="text-sm text-red-600 mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    <!-- More Info -->
                    <fieldset class="space-y-4">
                        <legend class="text-lg font-semibold text-blue-700 border-l-4 border-blue-500 pl-3">
                            <i class="bi bi-three-dots mr-2"></i> More Info
                        </legend>
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="bi bi-text-left mr-1 text-gray-500"></i> Description
                                </label>
                                <textarea id="description" name="description" rows="4"
                                    class="w-full rounded-lg border border-gray-300 shadow-sm focus:border-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    placeholder="Brief description of the app">{{ old('description', $app->description) }}</textarea>
                                @error('description')
                                    <p class="text-sm text-red-600 mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                         

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="bi bi-toggle-on mr-1 text-gray-500"></i> Status <span class="text-red-500">*</span>
                                </label>
                                <select id="status" name="status" required
                                    class="w-full rounded-lg border border-gray-300 shadow-sm focus:border-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value="active" {{ old('status', $app->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $app->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <p class="text-sm text-red-600 mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                </fieldset>

                <!-- Actions -->
                <div class="pt-6 border-t border-gray-100 flex justify-end space-x-4">
                    <a href="{{ url()->previous() }}"
                        class="inline-flex items-center px-4 py-2 bg-white text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 border border-gray-300">
                        <i class="bi bi-x-lg mr-2"></i> Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 border border-blue-600 shadow-sm">
                        <i class="bi bi-save mr-2"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
