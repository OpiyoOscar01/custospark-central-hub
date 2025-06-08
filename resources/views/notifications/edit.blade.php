@extends('layouts.employee')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('notifications.index') }}" class="hover:text-gray-700 flex items-center">
            <i class="bi bi-megaphone-fill mr-1 text-blue-600"></i> Notifications
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Edit Notification</span>
    </nav>

    {{-- Title --}}
    <h1 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
        <i class="bi bi-pencil-square text-blue-600 mr-3 text-2xl"></i> Edit Notification
    </h1>

    {{-- Form --}}
    <form action="{{ route('notifications.update', $notification) }}" method="POST">
        @csrf
        @method('PUT')
        @include('notifications.form')        

    </form>

    {{-- JS to show/hide user field --}}
    <script>
        const targetSelector = document.getElementById('target_type');
        const userIdField = document.getElementById('user_id_field');
        function toggleUserField() {
            userIdField.style.display = targetSelector.value === 'user' ? 'block' : 'none';
        }
        targetSelector.addEventListener('change', toggleUserField);
        document.addEventListener('DOMContentLoaded', toggleUserField);
    </script>
</div>
@endsection
