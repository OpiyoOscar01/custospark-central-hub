@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
            <p class="mt-2 text-sm text-gray-600">Manage system users and their roles per application</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('users.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500">
                <i class="bi bi-person-plus mr-2"></i>
                Add New User
            </a>
        </div>
    </div>

    <!-- Filters -->
   <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
    <form action="{{ route('users.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
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
                       placeholder="Search users..."
                       class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
        </div>

        <!-- App Selector -->
        <div>
            <label for="app_id" class="block text-sm font-medium text-gray-700 mb-1">App</label>
            <select name="app_id"
                    id="app_id"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">All Apps</option>
                @foreach($availableApps as $app)
                    <option value="{{ $app->id }}" {{ request('app_id', $appId) == $app->id ? 'selected' : '' }}>
                        {{ $app->name }}
                    </option>
                @endforeach
            </select>
        </div>


      <!-- App-scoped Roles -->
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
            <select name="role" 
                    id="role" 
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">All Roles</option>

                @php
                    $selectedAppId = request('app_id', $appId);
                    $selectedAppName = optional($availableApps->firstWhere('id', $selectedAppId))->name;
                    $rolesForApp = $rolesByApp->get($selectedAppName);
                @endphp

                @if($rolesForApp)
                    @foreach($rolesForApp as $role)
                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>


        <!-- Status -->
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" 
                    id="status" 
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">All Status</option>
                @foreach(['active', 'inactive', 'pending', 'suspended', 'banned'] as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filter Buttons -->
        <div class="flex items-end space-x-2 mr-2">
            <a href="{{ route('users.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white hover:bg-gray-50">
                <i class="bi bi-x-circle mr-2"></i>
                Clear
            </a>
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm text-white bg-blue-600 hover:bg-blue-700 mr-2">
                <i class="bi bi-filter-circle mr-2"></i>
                Filter
            </button>
        </div>
    </form>
</div>


<!-- Users Table -->
<div class="bg-white rounded-xl shadow overflow-x-auto border border-gray-200">
   <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-3 font-medium">#</th>
                    <th class="px-4 py-3 font-medium">Name</th>
                    <th class="px-4 py-3 font-medium">Email</th>
                    <th class="px-4 py-3 font-medium">Status</th>
                    <th class="px-4 py-3 font-medium">Roles</th>
                    <th class="px-4 py-3 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $index => $user)
                    <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                        <td class="px-4 py-3">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $user->email }}</td>
                        <td class="px-4 py-3 capitalize">{{ $user->status }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('users.edit', $user) }}" 
                               class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-full">
                                <i class="bi bi-person-gear mr-1"></i> Manage
                            </a>
                        </td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('users.show',$user) }}" class="text-blue-500 hover:text-blue-600" title="View">
                                <i class="bi bi-eye"></i> View
                            </a>
                            {{-- <a href="{{ route('users.edit', $user) }}" class="text-gray-500 hover:text-yellow-600" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('users.roles', $user) }}" class="text-gray-500 hover:text-purple-600" title="Roles">
                                <i class="bi bi-shield-lock"></i> --}}
                                   <form action="{{ route('users.destroy',$user) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-gray-500">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
</div>


    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->withQueryString()->links() }}
    </div>
</div>
@endsection
