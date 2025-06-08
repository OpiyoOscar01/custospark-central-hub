@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('roles.index') }}" class="hover:text-gray-700">Roles</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Edit Role</span>
    </nav>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                    <i class="bi bi-shield-lock text-blue-600 text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Role</h1>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('roles.update', $role->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="bi bi-info-circle text-blue-600"></i>
                        Role Details
                    </h2>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Role Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Role Name</label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name', $role->name) }}"
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm py-3"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- App Selection -->
                        <div>
                            <label for="app_id" class="block text-sm font-medium text-gray-700 mb-1">Select Application</label>
                            <select name="app_id"
                                    id="app_id"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm py-3"
                                    required>
                                <option value="">-- Select App --</option>
                                @foreach ($apps as $app)
                                    <option value="{{ $app->id }}" {{ old('app_id', $role->app_id) == $app->id ? 'selected' : '' }}>
                                        {{ $app->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('app_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Guard Name -->
                        @php $guardNames = ['web', 'api', 'admin']; @endphp
                        <div>
                            <label for="guard_name" class="block text-sm font-medium text-gray-700 mb-1 py-3">Guard Name</label>
                            <select name="guard_name"
                                    id="guard_name"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                                <option value="">-- Select Guard --</option>
                                @foreach ($guardNames as $guard)
                                    <option value="{{ $guard }}" {{ old('guard_name', $role->guard_name) == $guard ? 'selected' : '' }}>
                                        {{ ucfirst($guard) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('guard_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('roles.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <i class="bi bi-x-lg mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <i class="bi bi-check-lg mr-2"></i>
                        Update Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
