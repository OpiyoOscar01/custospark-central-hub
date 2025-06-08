@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

    <!-- Breadcrumb -->
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('roles.index') }}" class="hover:text-gray-700">Roles</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">{{ $role->name }}</span>
    </nav>

    <!-- Role Card -->
    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <div class="p-6 border-b border-gray-100 flex items-center gap-3">
            <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                <i class="bi bi-shield-check text-blue-600 text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900"><span class="text-blue-500">{{ $role->name }}</span> Role</h1>
        </div>

        <div class="p-6 space-y-6">
            <!-- Role Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Role Name</p>
                    <p class="text-base font-medium text-gray-900">{{ $role->name }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Guard Name</p>
                    <p class="text-base font-medium text-gray-900">{{ $role->guard_name }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">App</p>
                    <p class="text-base font-medium text-gray-900">
                        {{ $role->app->name ?? 'N/A' }}
                    </p>
                </div>
            </div>

            <!-- Permissions -->
            <div>
                <p class="text-sm text-gray-500 mb-2">Permissions</p>
                @if ($role->permissions->count())
                    <div class="flex flex-wrap gap-2">
                        @foreach ($role->permissions as $permission)
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-sm font-medium text-blue-700 border border-blue-200">
                                {{ $permission->name }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-sm">No permissions assigned.</p>
                @endif
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="p-6 border-t border-gray-100 flex items-center justify-between">
            <a href="{{ route('roles.edit', $role->id) }}"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                <i class="bi bi-pencil-fill mr-2"></i> Edit
            </a>

            <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this role?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg">
                    <i class="bi bi-trash-fill mr-2"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
