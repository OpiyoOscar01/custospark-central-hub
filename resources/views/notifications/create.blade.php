@extends('layouts.employee')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8 flex items-center">
        <i class="bi bi-megaphone-fill text-blue-600 mr-3 text-2xl"></i> Create Notification
    </h1>

    <div class="bg-white p-6 rounded-xl shadow-md border-gray-200">
        <form action="{{ route('notifications.store') }}" method="POST">
            @csrf

            <!-- Title -->
            <div class="mb-5">
                <label for="title" class="block text-sm font-medium text-gray-700">
                    <i class="bi bi-type-bold mr-1 text-gray-500"></i> Title
                </label>
                <input type="text" name="title" id="title"
                    value="{{ old('title',  '') }}"
                    class="mt-1 block w-full rounded-lg border-gray-900 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Enter notification title" required>
            </div>

            <!-- Message -->
            <div class="mb-5">
                <label for="message" class="block text-sm font-medium text-gray-700">
                    <i class="bi bi-chat-left-text-fill mr-1 text-gray-500"></i> Message
                </label>
                <textarea name="message" id="message" rows="4"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Write your message here..." required>{{ old('message', '') }}</textarea>
            </div>

            <!-- Target -->
            <div class="mb-5">
                <label for="target_type" class="block text-sm font-medium text-gray-700">
                    <i class="bi bi-bullseye mr-1 text-gray-500"></i> Target
                </label>
                <select name="target_type" id="target_type"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required>
                    <option value="">Select target</option>
                    <option value="system" {{ old('target_type') == 'system' ? 'selected' : '' }}>System-wide</option>
                    <option value="user" {{ old('target_type') == 'user' ? 'selected' : '' }}>Specific User</option>
                </select>
            </div>

            <!-- User ID (shown only when target is 'user') -->
            <div class="mb-5 hidden" id="user_id_field">
                <label for="user_id" class="block text-sm font-medium text-gray-700">
                    <i class="bi bi-person-lines-fill mr-1 text-gray-500"></i> Choose User
                </label>
                <select name="user_id" id="user_id"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Select user</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Channel -->
            <div class="mb-6">
                <label for="channel" class="block text-sm font-medium text-gray-700">
                    <i class="bi bi-broadcast-pin mr-1 text-gray-500"></i> Channel
                </label>
                <select name="channel" id="channel"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required>
                    <option value="in_app" {{ old('channel') == 'in_app' ? 'selected' : '' }}>In-App</option>
                    <option value="email" {{ old('channel') == 'email' ? 'selected' : '' }}>Email</option>
                    <option value="both" {{ old('channel') == 'both' ? 'selected' : '' }}>Both</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none">
                    <i class="bi bi-send-fill mr-2"></i> Send Notification
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    const targetSelector = document.getElementById('target_type');
    const userIdField = document.getElementById('user_id_field');

    function toggleUserField() {
        if (targetSelector.value === 'user') {
            userIdField.classList.remove('hidden');
        } else {
            userIdField.classList.add('hidden');
        }
    }

    targetSelector.addEventListener('change', toggleUserField);
    document.addEventListener('DOMContentLoaded', toggleUserField);
</script>
@endsection


