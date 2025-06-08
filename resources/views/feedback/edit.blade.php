@extends('layouts.employee')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex space-x-2">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:underline flex items-center">
                    <i class="bi bi-house-door-fill mr-1"></i> Dashboard
                </a>
                <span class="mx-2">/</span>
            </li>
            <li class="inline-flex items-center">
                <a href="{{ route('feedback.index') }}" class="text-indigo-600 hover:underline flex items-center">
                    <i class="bi bi-chat-left-text-fill mr-1"></i> Feedback
                </a>
                <span class="mx-2">/</span>
            </li>
            <li class="inline-flex items-center text-gray-700">
                <i class="bi bi-pencil-fill mr-1"></i> Manage Feedback
            </li>
        </ol>
    </nav>

    <div class="bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="bi bi-tools text-indigo-600 mr-2"></i>
            Manage Feedback
        </h2>

        <form method="POST" action="{{ route('feedback.update', $feedback->id) }}">
            @csrf
            @method('PUT')

            <!-- Status -->
            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 py-4">
                    @foreach (['pending','triaged','in_progress','resolved','responded','closed','rejected'] as $status)
                        <option value="{{ $status }}" @selected($feedback->status === $status)>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Admin Response -->
            <div class="mb-6">
                <label for="admin_response" class="block text-sm font-medium text-gray-700">Admin Response</label>
                <textarea name="admin_response" id="admin_response" rows="5"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
                >{{ old('admin_response', $feedback->admin_response) }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-700 transition">
                    <i class="bi bi-save2-fill mr-2"></i> Update Feedback
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
