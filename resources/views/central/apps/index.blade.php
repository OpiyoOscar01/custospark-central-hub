@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Header -->
    {{-- <div class="mb-6 flex items-center justify-between">
        
        <div class="flex items-center gap-3">
            <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                <i class="bi bi-grid-1x2 text-blue-600 text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Apps</h1>
        </div>
        <a href="{{ route('apps.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="bi bi-plus-lg mr-2"></i> New App
        </a>
    </div> --}}
       <div class="md:flex md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">App Management</h1>
            <p class="mt-2 text-sm text-gray-600">Manage all Custospark Apps.</p>
        </div>
        <div class="mt-4 md:mt-0">
              <a href="{{ route('apps.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="bi bi-plus-lg mr-2"></i> New App
        </a>
        </div>
    </div>

    <!-- Responsive Table Wrapper -->
  <div class="bg-white rounded-xl shadow overflow-x-auto border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
        <thead class="bg-gray-50 text-gray-700">
            <tr>
                <th class="px-4 py-3 font-medium">#</th>
                <th class="px-4 py-3 font-medium">Name</th>
                <th class="px-4 py-3 font-medium">Slug</th>
                <th class="px-4 py-3 font-medium">Status</th>
                <th class="px-4 py-3 font-medium">Base URL</th>
                <th class="px-4 py-3 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-gray-700">
            @forelse ($apps as $app)
                <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                    <td class="px-4 py-3 text-gray-900">
                        {{ $loop->iteration + ($apps->currentPage() - 1) * $apps->perPage() }}
                    </td>

                    <td class="px-4 py-3 text-gray-900">
                        <div class="flex items-center justify-center gap-2">
                            @if($app->icon_url)
                                <img src="{{ asset('images/custospark.png') }}" alt="Icon" class="w-6 h-6 rounded-md">
                            @else
                                <i class="bi bi-app-indicator text-lg text-blue-400"></i>
                            @endif
                            <a href="{{ route('apps.show', $app) }}" class="text-blue-500 hover:underline font-medium">
                                {{ $app->name }}
                            </a>
                        </div>
                    </td>

                    <td class="px-4 py-3 text-gray-600">{{ $app->slug }}</td>

                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            {{ $app->status === 'active' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($app->status) }}
                        </span>
                    </td>

                    <td class="px-4 py-3 text-gray-600">
                        <a href="{{ $app->base_url }}" target="_blank" class="text-blue-600 hover:underline">
                            {{ Str::limit($app->base_url, 30) }}
                        </a>
                    </td>

                    <td class="px-4 py-3 space-x-2">
                        <a href="{{ route('apps.show', $app) }}" class="text-blue-500 hover:text-blue-600" title="View">
                            <i class="bi bi-eye-fill"></i> View
                        </a>
                        <a href="{{ route('apps.edit', $app) }}" class="text-blue-500 hover:text-blue-600" title="Edit">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('apps.destroy', $app) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this app?');"
                              class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-6 text-center text-gray-500">
                        <i class="bi bi-exclamation-circle-fill mr-1"></i> No apps found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


</div>
@endsection
