@extends('layouts.employee')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('notifications.index') }}" class="hover:text-gray-700 flex items-center">
            <i class="bi bi-megaphone-fill mr-1 text-blue-600"></i> Notifications
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Notification Details</span>
    </nav>

    {{-- Title --}}
    <h1 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
        <i class="bi bi-info-circle-fill text-blue-600 mr-3 text-2xl"></i> Notification Details
    </h1>

    {{-- Details Card --}}
    <div class="bg-white rounded-xl shadow border border-gray-200 p-6 space-y-6">

        {{-- Title --}}
        <div class="flex items-start">
            <i class="bi bi-type-bold text-gray-500 mr-3 mt-1 text-xl"></i>
            <div>
                <h2 class="text-sm font-semibold text-gray-600">Title</h2>
                <p class="text-gray-900">{{ $notification->title }}</p>
            </div>
        </div>

        {{-- Message --}}
        <div class="flex items-start">
            <i class="bi bi-chat-left-text text-gray-500 mr-3 mt-1 text-xl"></i>
            <div>
                <h2 class="text-sm font-semibold text-gray-600">Message</h2>
                <p class="text-gray-700 whitespace-pre-line">{{ $notification->message }}</p>
            </div>
        </div>

        {{-- Target & Channel --}}
        <div class="grid grid-cols-2 gap-4">
            <div class="flex items-start">
                <i class="bi bi-bullseye text-gray-500 mr-3 mt-1 text-lg"></i>
                <div>
                    <h2 class="text-sm font-semibold text-gray-600">Target</h2>
                    <p class="text-gray-800 capitalize">{{ $notification->target_type }}</p>
                </div>
            </div>

            <div class="flex items-start">
                <i class="bi bi-broadcast-pin text-gray-500 mr-3 mt-1 text-lg"></i>
                <div>
                    <h2 class="text-sm font-semibold text-gray-600">Channel</h2>
                    <p class="text-gray-800 capitalize">{{ $notification->channel }}</p>
                </div>
            </div>

            {{-- Recipient (if applicable) --}}
            @if($notification->user)
            <div class="col-span-2 flex items-start">
                <i class="bi bi-person-lines-fill text-gray-500 mr-3 mt-1 text-lg"></i>
                <div>
                    <h2 class="text-sm font-semibold text-gray-600">Recipient User</h2>
                    <p class="text-gray-800">
                        {{ $notification->user->first_name }} {{ $notification->user->last_name }} ({{ $notification->user->email }})
                    </p>
                </div>
            </div>
            @endif
        </div>

        {{-- Back Link --}}
        <div class="pt-4">
            <a href="{{ route('notifications.index') }}"
                class="inline-flex items-center text-sm text-blue-600 hover:underline">
                <i class="bi bi-arrow-left-short mr-1 text-lg"></i> Back to Notifications
            </a>
        </div>
    </div>
</div>
@endsection
