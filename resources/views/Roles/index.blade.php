@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">


    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Role Management</h1>
            <p class="mt-2 text-sm text-gray-600">Manage roles per application with scoped permissions</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('roles.create') }}"
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:ring-blue-400">
                <i class="bi bi-shield-plus mr-2"></i>
                Add New Role
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <form action="{{ route('roles.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="bi bi-search text-gray-400"></i>
                    </div>
                    <input type="text"
                           name="search"
                           id="search"
                           value="{{ request('search') }}"
                           placeholder="Search roles..."
                           class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>

            <!-- App Filter -->
            <div>
                <label for="app_id" class="block text-sm font-medium text-gray-700 mb-1">App</label>
                <select name="app_id" id="app_id"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">All Apps</option>
                    @foreach($availableApps as $app)
                        <option value="{{ $app->id }}" {{ request('app_id') == $app->id ? 'selected' : '' }}>
                            {{ $app->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-end space-x-2 col-span-2">
                <a href="{{ route('roles.index') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white hover:bg-gray-50">
                    <i class="bi bi-x-circle mr-2"></i>
                    Clear
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm text-white bg-blue-600 hover:bg-blue-700">
                    <i class="bi bi-filter-circle mr-2"></i>
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Roles Table -->
    <div class="bg-white rounded-xl shadow overflow-x-auto border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-3 font-medium">#</th>
                    <th class="px-4 py-3 font-medium">Name</th>
                    <th class="px-4 py-3 font-medium">Guard</th>
                    <th class="px-4 py-3 font-medium">App</th>
                    <th class="px-4 py-3 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($roles as $role)
                    <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                        <td class="px-4 py-3">{{ $loop->iteration + ($roles->currentPage() - 1) * $roles->perPage() }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $role->name }}</td>
                        <td class="px-4 py-3">{{ $role->guard_name }}</td>
                        <td class="px-4 py-3">
                            {{ optional($availableApps->firstWhere('id', $role->app_id))->name ?? '—' }}
                        </td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{route('roles.edit',$role->id)}}" class="text-blue-500 hover:text-blue-600" title="Edit">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="{{route('roles.show',$role->id)}}" class="text-blue-500 hover:text-blue-600" title="View">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <form action="{{ route('roles.destroy',$role) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this role?');">
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
                        <td colspan="5" class="py-6 text-center text-gray-500">No roles found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $roles->withQueryString()->links() }}
    </div>

</div>
@endsection
