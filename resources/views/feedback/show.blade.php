@extends('layouts.employee')

@section('title', 'View Feedback')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-400 flex items-center gap-2 mb-6">
        <a href="{{ route('feedback.index') }}" class="hover:text-indigo-600 transition font-medium">Feedback</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900 font-semibold">View Feedback</span>
    </nav>

    {{-- User & App Info --}}
    <section class="bg-white rounded-2xl shadow-md p-6 grid grid-cols-1 md:grid-cols-2 gap-8 border border-gray-100">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="bi bi-person-circle text-indigo-500 text-xl"></i> User Information
            </h2>
            @if ($feedback->user)
                <p class="text-sm text-gray-700"><span class="font-semibold">Name:</span> {{ $feedback->user->first_name }} {{ $feedback->user->last_name }}</p>
                <p class="text-sm text-gray-700"><span class="font-semibold">Email:</span> {{ $feedback->user->email }}</p>
                <p class="text-sm text-gray-700"><span class="font-semibold">Phone:</span> {{ $feedback->user->phone ?? 'N/A' }}</p>
            @else
                <p class="italic text-gray-400">User info not available.</p>
            @endif
        </div>

        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="bi bi-box text-indigo-500 text-xl"></i> Application Information
            </h2>
            @if ($feedback->app)
                <p class="text-sm text-gray-700"><span class="font-semibold">App Name:</span> {{ $feedback->app->name }}</p>
                <p class="text-sm text-gray-700"><span class="font-semibold">App ID:</span> {{ $feedback->app->id }}</p>
            @else
                <p class="italic text-gray-400">App info not available.</p>
            @endif
        </div>
    </section>

    {{-- Feedback Overview --}}
    <section class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 space-y-2">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="bi bi-chat-left-text text-indigo-500 text-xl"></i> Feedback Overview
        </h2>
        <div class="text-sm text-gray-700 space-y-1">
            <p><span class="font-semibold">Type:</span> {{ ucfirst(str_replace('_', ' ', $feedback->type)) }}</p>
            <p><span class="font-semibold">Source:</span> {{ ucfirst($feedback->source) }}</p>
            <p class="flex items-center gap-2">
                <span class="font-semibold">Status:</span>
                <span class="px-2 py-1 text-xs rounded-full text-white capitalize
                    @switch($feedback->status)
                        @case('pending') bg-yellow-500 @break
                        @case('triaged') bg-orange-500 @break
                        @case('in_progress') bg-blue-500 @break
                        @case('resolved') bg-green-600 @break
                        @case('responded') bg-teal-600 @break
                        @case('closed') bg-gray-700 @break
                        @case('rejected') bg-red-600 @break
                        @default bg-gray-400
                    @endswitch
                ">
                    {{ str_replace('_', ' ', $feedback->status) }}
                </span>
            </p>
            <p><span class="font-semibold">Rating:</span> {{ $feedback->rating ?? 'N/A' }}</p>
            <p><span class="font-semibold">Created At:</span> {{ $feedback->created_at->format('M d, Y H:i') }}</p>
            <p><span class="font-semibold">Updated At:</span> {{ $feedback->updated_at->format('M d, Y H:i') }}</p>
        </div>
    </section>

    {{-- Complaint Categories --}}
    @if($feedback->complaint_categories)
    <section class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="bi bi-exclamation-triangle text-indigo-500 text-xl"></i> Complaint Categories
        </h2>
        <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
            @foreach($feedback->complaint_categories as $category)
                <li>{{ ucfirst($category) }}</li>
            @endforeach
        </ul>
    </section>
    @endif

    {{-- Attachments --}}
@if($feedback->attachments)
    <section class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="bi bi-paperclip text-indigo-500 text-xl"></i> Attachments
        </h2>
        <ul class="list-disc list-inside text-sm text-indigo-600 space-y-1">
            @foreach($feedback->attachments as $file)
                <li>
                    <a href="{{ asset('storage/' . $file) }}" target="_blank" class="hover:underline">
                        {{ basename($file) }}
                    </a>
                </li>
            @endforeach
        </ul>
    </section>
@endif

    

    {{-- Message & Admin Response --}}
    <section class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 space-y-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <i class="bi bi-envelope text-indigo-500 text-xl"></i> User Message
            </h2>
            <p class="whitespace-pre-line text-sm text-gray-700">{{ $feedback->message }}</p>
        </div>

        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <i class="bi bi-person-badge text-indigo-500 text-xl"></i> Admin Response
            </h2>
            @if ($feedback->admin_response)
                <p class="whitespace-pre-line text-sm text-gray-700">{{ $feedback->admin_response }}</p>
                <p class="text-xs text-gray-500 mt-1">Responded at: {{ optional($feedback->responded_at)->format('M d, Y H:i') }}</p>
            @else
                <p class="italic text-gray-400">No response yet.</p>
            @endif
        </div>
    </section>

    {{-- Admin Info & Status Update --}}
    <section class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="bi bi-gear text-indigo-500 text-xl"></i> Management
        </h2>
        <p class="text-sm text-gray-700 mb-4">
            <span class="font-semibold">Handled By:</span> {{ $feedback->admin ? $feedback->admin->name : 'N/A' }}
        </p>

        <form action="{{ route('feedback.update', $feedback->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Update Status</label>
                <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    @foreach(['pending', 'triaged', 'in_progress', 'resolved', 'responded', 'closed', 'rejected'] as $status)
                        <option value="{{ $status }}" {{ $feedback->status === $status ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700 transition">
                <i class="bi bi-check2-circle mr-2"></i> Update Status
            </button>
        </form>
    </section>
</div>
@endsection
