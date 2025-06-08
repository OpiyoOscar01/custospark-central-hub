@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('projects.show', $project) }}" class="hover:text-gray-700">Project Details</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Documents</span>
    </nav>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                        <i class="bi bi-folder text-blue-600 text-xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900"><span class="text-blue-500">{{ $project->name }}</span> Documents</h1>
                </div>
                <a href="{{ route('documents.create', ['project' => $project->id]) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="bi bi-cloud-upload mr-2"></i>
                    Upload Document
                </a>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($documents as $document)
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                        <div class="p-5">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="p-2 bg-gray-100 rounded-lg border border-gray-200">
                                        <i class="bi bi-file-earmark-text text-gray-500 text-2xl"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base font-medium text-gray-900 truncate">
                                        {{ $document->file_name }}
                                    </h3>
                                    <div class="mt-1 flex items-center text-sm text-gray-500">
                                        <i class="bi bi-person mr-1"></i>
                                        <span>{{ $document->uploader->name }}</span>
                                    </div>
                                    <div class="mt-1 flex items-center text-sm text-gray-500">
                                        <i class="bi bi-calendar mr-1"></i>
                                        <span>{{ $document->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex items-center justify-end space-x-3">
                                <a href="{{ route('documents.download', $document) }}" 
                                   class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="bi bi-download mr-1.5"></i>
                                    Download
                                </a>
                                <form action="{{ route('documents.destroy', $document) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure you want to delete this document?')" 
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <i class="bi bi-trash mr-1.5"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-12">
                            <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center">
                                <i class="bi bi-file-earmark-text text-4xl text-gray-400"></i>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">No Documents Found</h3>
                            <p class="mt-2 text-sm text-gray-500">Get started by uploading your first document.</p>
                            <div class="mt-6">
                                <a href="{{ route('documents.create', ['project' => $project->id]) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="bi bi-cloud-upload mr-2"></i>
                                    Upload Document
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- @if($documents->hasPages())
                <div class="mt-6">
                    {{ $documents->links() }}
                </div>
            @endif --}}
        </div>
    </div>
</div>
@endsection