@extends('layouts.employee')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 flex items-center gap-2 mb-6">
        <a href="{{ route('users.index') }}" class="hover:text-gray-800 transition">Users</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900 font-medium">Access Control</span>
    </nav>

    


 {{-- Toast Feedback
@if(session('success'))
    <div 
        id="toast" 
        class="fixed top-6 right-6 z-50 flex items-start gap-3 max-w-sm p-4 border rounded-xl shadow-xl bg-white border-blue-200 animate-fade-in-down"
    >
        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-500">
            <i class="bi bi-check-circle-fill text-xl"></i>
        </div>
        <div class="flex-1">
            <p class="text-sm font-semibold text-gray-800 mb-1">Success</p>
            <p class="text-sm text-gray-600">{{ session('success') }}</p>
        </div>
        <button 
            onclick="document.getElementById('toast')?.remove()" 
            class="text-gray-400 hover:text-gray-600 transition"
        >
            <i class="bi bi-x-lg text-sm"></i>
        </button>
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => toast.remove(), 500);
            }
        }, 5000);
    </script>
@endif --}}


    {{-- Page Heading --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
            <i class="bi bi-person-gear text-indigo-600 text-2xl"></i>
            Manage Access Control for <span class="text-blue-500">{{ $user->first_name }} {{ $user->last_name }}.</span>
        </h1>
    </div>

    {{-- User Profile Info --}}
    <section class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 space-y-6">
        <h2 class="text-lg font-semibold text-gray-700 flex items-center gap-2">
            <i class="bi bi-person-circle text-indigo-500"></i> User Profile
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <x-user-field label="First Name" icon="bi-person" :value="$user->first_name" />
            <x-user-field label="Last Name" icon="bi-person" :value="$user->last_name" />
            <x-user-field label="Email" icon="bi-envelope" :value="$user->email" />
        </div>
    </section>

    {{-- Quick Status Toggle --}}
    <section class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
        <h2 class="text-sm font-semibold text-gray-700 flex items-center gap-2 mb-4">
            <i class="bi bi-toggle-on text-indigo-500"></i> Quick Status
        </h2>
        <div class="flex flex-wrap gap-3">
            @foreach(['active', 'inactive', 'pending', 'suspended', 'banned'] as $status)
                <form action="{{ route('users.update.status', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="{{ $status }}">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium transition focus:ring-2 focus:ring-offset-1
                            {{ $user->status === $status 
                                ? 'bg-indigo-100 text-indigo-700 hover:bg-indigo-200 focus:ring-indigo-300' 
                                : 'bg-gray-100 text-gray-700 hover:bg-gray-200 focus:ring-gray-300' }}">
                        <i class="bi {{ $user->status === $status ? 'bi-check-circle-fill' : 'bi-circle' }} mr-2"></i>
                        {{ ucfirst($status) }}
                    </button>
                </form>
            @endforeach
        </div>
    </section>

    {{-- Access Control per App --}}
    <h2 class="text-2xl font-semibold text-gray-700 flex items-center gap-2 mb-1 text-center">
        <i class="bi bi-shield-lock text-indigo-500"></i><span class="text-blue-500">{{ $user->first_name }}'s</span> Roles and Permissions across Custospark Apps.
        </h2>
        <hr class="text-blue">
    <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($apps as $app)
        <div class="bg-white border border-gray-100 rounded-2xl shadow-md p-6 flex flex-col justify-between gap-6">
            {{-- App Header --}}
            <div class="flex justify-between items-start">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i class="bi bi-box text-blue-600"></i> {{ $app->name }}
                </h3>
                <span class="text-xs text-gray-400">Slug: <span class="text-blue-500">{{ $app->slug }}</span></span>
            </div>

            {{-- Roles Section --}}
            <div>
                <h4 class="text-sm font-semibold text-gray-900 flex items-center gap-2 mb-2">
                    <i class="bi bi-person-check text-blue-500"></i> Roles
                </h4>
                <div class="flex flex-wrap gap-2">
                    @forelse($rolesByApp[$app->id] ?? [] as $role)
                        <form action="{{ route('users.toggle-role', [$user->id, $app->id, $role->name]) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium transition
                                    {{ $user->hasRoleWithApp($role->name, $app->id)
                                        ? 'bg-indigo-200 text-blue-500 hover:bg-blue-200'
                                        : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                <i class="bi {{ $user->hasRoleWithApp($role->name, $app->id) ? 'bi-check-circle-fill' : 'bi-circle' }} mr-2"></i>
                                {{ $role->name }}
                            </button>
                        </form>
                    @empty
                        <span class="text-xs text-gray-400 italic">No roles found</span>
                    @endforelse
                </div>
            </div>

            {{-- Permissions Section --}}
            <div>
                <h4 class="text-sm font-semibold text-gray-700 flex items-center gap-2 mb-2">
                    <i class="bi bi-shield-check text-blue-500"></i> Permissions
                </h4>
                <div class="flex flex-wrap gap-2">
                    @forelse($permissionsByApp[$app->id] ?? [] as $permission)
                        <form action="{{ route('users.toggle-permission', [$user->id, $app->id, $permission->name]) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium transition
                                    {{ $user->getAppPermissionNames($app->id)->contains($permission->name)
                                        ? 'bg-blue-100 text-blue-700 hover:bg-blue-200'
                                        : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                <i class="bi {{ $user->getAppPermissionNames($app->id)->contains($permission->name) ? 'bi-check2-square' : 'bi-square' }} mr-2"></i>
                                {{ Str::title(str_replace('_', ' ', $permission->name)) }}
                            </button>
                        </form>
                    @empty
                        <span class="text-xs text-gray-400 italic">No permissions found</span>
                    @endforelse
                </div>
            </div>
        </div>
        @endforeach
    </section>
</div>
@endsection
