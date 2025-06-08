@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('resources.index') }}" class="hover:text-gray-700">Resources</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Edit Resource</span>
    </nav>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                    <i class="bi bi-cloud-upload text-blue-600 text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Resource</h1>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('resources.update', $resource->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Resource Type Section -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="bi bi-file-earmark-text text-blue-600"></i>
                        Resource Details
                    </h2>

                    <div class="space-y-6">
                        <!-- Resource Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-pencil-square text-gray-400 mr-1"></i>
                                Resource Title
                            </label>
                            <input id="title" name="title" type="text" class="form-input block w-full border-gray-300 rounded-md" value="{{ old('title', $resource->title) }}" required>
                            @error('title')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Resource Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-file-earmark-text text-gray-400 mr-1"></i>
                                Resource Description
                            </label>
                            <textarea id="description" name="description" class="form-textarea block w-full border-gray-300 rounded-md" rows="4" required>{{ old('description', $resource->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Resource Type -->
                        <div>
                            <label for="resource_type" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-tags text-gray-400 mr-1"></i>
                                Resource Type
                            </label>
                            <select id="resource_type" name="resource_type" class="form-select block w-full border-gray-300 rounded-md" required>
                                <option value="document" {{ $resource->resource_type == 'document' ? 'selected' : '' }}>Document</option>
                                <option value="video" {{ $resource->resource_type == 'video' ? 'selected' : '' }}>Video</option>
                                <option value="link" {{ $resource->resource_type == 'link' ? 'selected' : '' }}>Link</option>
                                <option value="template" {{ $resource->resource_type == 'template' ? 'selected' : '' }}>Template</option>
                                <option value="guide" {{ $resource->resource_type == 'guide' ? 'selected' : '' }}>Guide</option>
                            </select>
                            @error('resource_type')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="bi bi-file-earmark-arrow-up text-gray-400 mr-1"></i>
                                Select File
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                                <div class="space-y-2 text-center">
                                    <div class="mx-auto h-12 w-12 text-gray-400">
                                        <i class="bi bi-cloud-arrow-up text-3xl"></i>
                                    </div>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="file" name="file" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PDF, Word documents, Images, and Video files up to 10MB
                                    </p>
                                </div>
                            </div>
                            @error('file')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('resources.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="bi bi-x-lg mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="bi bi-cloud-upload mr-2"></i>
                        Update Resource
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add any custom JavaScript here if needed
</script>
@endsection
