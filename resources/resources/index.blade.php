@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Resources Management</span>
    </nav>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-5">
      <!-- Document Resources -->
      <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
          <div class="p-5">
              <div class="flex items-center space-x-4">
                  <div class="flex-shrink-0">
                      <div class="bg-blue-100 text-blue-600 rounded-xl p-3 border border-blue-200">
                          <i class="bi bi-file-earmark-text text-2xl"></i>
                      </div>
                  </div>
                  <div class="flex-1">
                      <dl>
                          <dt class="text-sm font-medium text-gray-500 truncate">Documents</dt>
                          <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['documents'] }}</dd>
                      </dl>
                      <div class="mt-4">
                          <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">Explore Documents</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  
      <!-- Video Resources -->
      <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
          <div class="p-5">
              <div class="flex items-center space-x-4">
                  <div class="flex-shrink-0">
                      <div class="bg-red-100 text-red-600 rounded-xl p-3 border border-red-200">
                          <i class="bi bi-camera-video text-2xl"></i>
                      </div>
                  </div>
                  <div class="flex-1">
                      <dl>
                          <dt class="text-sm font-medium text-gray-500 truncate">Videos</dt>
                          <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['videos'] }}</dd>
                      </dl>
                      <div class="mt-4">
                          <a href="#" class="text-red-600 hover:text-red-800 text-sm font-semibold">Explore Videos</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  
      <!-- Link Resources -->
      <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
          <div class="p-5">
              <div class="flex items-center space-x-4">
                  <div class="flex-shrink-0">
                      <div class="bg-yellow-100 text-yellow-600 rounded-xl p-3 border border-yellow-200">
                          <i class="bi bi-link-45deg text-2xl"></i>
                      </div>
                  </div>
                  <div class="flex-1">
                      <dl>
                          <dt class="text-sm font-medium text-gray-500 truncate">Links</dt>
                          <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['links'] }}</dd>
                      </dl>
                      <div class="mt-4">
                          <a href="#" class="text-yellow-600 hover:text-yellow-800 text-sm font-semibold">Explore Links</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  
      <!-- Template Resources -->
      <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
          <div class="p-5">
              <div class="flex items-center space-x-4">
                  <div class="flex-shrink-0">
                      <div class="bg-green-100 text-green-600 rounded-xl p-3 border border-green-200">
                          <i class="bi bi-file-earmark-text text-2xl"></i>
                      </div>
                  </div>
                  <div class="flex-1">
                      <dl>
                          <dt class="text-sm font-medium text-gray-500 truncate">Templates</dt>
                          <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['templates'] }}</dd>
                      </dl>
                      <div class="mt-4">
                          <a href="#" class="text-green-600 hover:text-green-800 text-sm font-semibold">Explore Templates</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  
      <!-- Guide Resources -->
      <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
          <div class="p-5">
              <div class="flex items-center space-x-4">
                  <div class="flex-shrink-0">
                      <div class="bg-teal-100 text-teal-600 rounded-xl p-3 border border-teal-200">
                          <i class="bi bi-book text-2xl"></i>
                      </div>
                  </div>
                  <div class="flex-1">
                      <dl>
                          <dt class="text-sm font-medium text-gray-500 truncate">Guides</dt>
                          <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['guides'] }}</dd>
                      </dl>
                      <div class="mt-4">
                          <a href="#" class="text-teal-600 hover:text-teal-800 text-sm font-semibold">Explore Guides</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  
  

    <!-- Resources List -->
    <div class="mt-8 bg-white shadow-lg rounded-xl border border-gray-200">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                        <i class="bi bi-folder text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Resource Listings</h1>
                        <p class="mt-1 text-sm text-gray-500">Manage your available resources</p>
                    </div>
                </div>
                <a href="{{ route('resources.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700">
                    <i class="bi bi-plus-lg mr-2"></i>
                    Add New Resource
                </a>
            </div>
        </div>

        <div class="p-6">
            <!-- Search and Filters -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="relative">
                    <input type="text" 
                           placeholder="Search resources..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="bi bi-search text-gray-400"></i>
                    </div>
                </div>
                <div>
                  <select class="block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 bg-white text-gray-900 text-sm font-medium">
                      <option value="">All Resource Types</option>
                      <option value="document" class="flex items-center space-x-2">
                          <span class="inline-block w-4 h-4 bg-blue-500 rounded-full"></span>
                          <span>Document</span>
                      </option>
                      <option value="video" class="flex items-center space-x-2">
                          <span class="inline-block w-4 h-4 bg-red-500 rounded-full"></span>
                          <span>Video</span>
                      </option>
                      <option value="link" class="flex items-center space-x-2">
                          <span class="inline-block w-4 h-4 bg-yellow-500 rounded-full"></span>
                          <span>Link</span>
                      </option>
                      <option value="template" class="flex items-center space-x-2">
                          <span class="inline-block w-4 h-4 bg-green-500 rounded-full"></span>
                          <span>Template</span>
                      </option>
                      <option value="guide" class="flex items-center space-x-2">
                          <span class="inline-block w-4 h-4 bg-teal-500 rounded-full"></span>
                          <span>Guide</span>
                      </option>
                  </select>
              </div>
              
                <div>
                    <select class="block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Roles</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
            </div>

            <!-- Resource Table -->
            <div class="overflow-x-auto mt-4">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resource Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Roles</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created By</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($resources as $resource)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $resource->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($resource->resource_type) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @foreach(json_decode($resource->visible_to_roles) as $role)
                                        <span class="text-gray-700">{{ ucfirst($role) }}</span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $resource->createdBy->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="{{ route('resources.show', $resource->id) }}" 
                                           class="text-blue-600 hover:text-blue-900" title="View Resource Details">
                                            <i class="bi bi-eye"></i>
                                            <span class="sr-only">View</span>
                                        </a>
                                        <a href="{{ route('resources.edit', $resource->id) }}" 
                                           class="text-yellow-600 hover:text-yellow-900" title="Edit Resource">
                                            <i class="bi bi-pencil"></i>
                                            <span class="sr-only">Edit</span>
                                        </a>
                                        <form action="{{ route('resources.destroy', $resource->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete Resource" class="text-red-600 hover:text-red-900">
                                                <i class="bi bi-trash"></i>
                                                <span class="sr-only">Delete</span>
                                            </button>
                                        </form>
                                    </div>
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
