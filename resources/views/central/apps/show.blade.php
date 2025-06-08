@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-6 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('apps.index') }}" class="hover:text-gray-700">Apps</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">{{ $app->name }}</span>
    </nav>

    <!-- Info Card -->
    <div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                    <i class="bi bi-info-circle text-blue-500 text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">App Details</h1>
            </div>
            <a href="{{ route('apps.edit', $app) }}" class="text-blue-500 hover:text-blue-700">
                <i class="bi bi-pencil-square text-xl"></i>
            </a>
        </div>

        <!-- Body -->
        <div class="p-8 space-y-10">
            <!-- Basic Info -->
            <div>
                <h2 class="text-lg font-semibold text-blue-700 border-l-4 border-blue-500 pl-3 mb-4">
                    <i class="bi bi-card-list mr-2"></i> Basic Information
                </h2>
                <dl class="grid md:grid-cols-2 gap-6 text-sm text-gray-700">
                    <div>
                        <dt class="font-medium">App Name</dt>
                        <dd class="mt-1 text-gray-900">{{ $app->name }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium">App Tagline</dt>
                        <dd class="mt-1 text-gray-900">{{ $app->tagline??"NA" }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium">Slug</dt>
                        <dd class="mt-1 text-gray-900">{{ $app->slug }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium">Base URL</dt>
                        <dd class="mt-1 text-blue-600">
                            <a href="{{ $app->base_url }}" target="_blank" class="hover:underline">
                                {{ $app->base_url }}
                            </a>
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium">Icon URL</dt>
                        <dd class="mt-1">
                            @if ($app->icon_url)
                                <img src="{{ $app->icon_url }}" alt="App Icon" class="h-10">
                            @else
                                <span class="text-gray-500">Not set</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium">Status</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full 
                                {{ $app->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($app->status) }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Description -->
            <div>
                <h2 class="text-lg font-semibold text-blue-500 border-l-4 border-blue-500 pl-3 mb-4">
                    <i class="bi bi-text-left mr-2"></i> Description
                </h2>
                <p class="text-sm text-gray-800">
                    {{ $app->description ?: 'No description provided.' }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
