@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Notifications</h1>
            <p class="mt-2 text-sm text-gray-600">Manage system and user notifications</p>
        </div>
        <div class="mt-4 md:mt-0">
         <a href="{{ route('notifications.create') }}" 
   class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500">
    <i class="bi-bell-fill"></i>
    <i class="bi-plus-lg mr-2"></i>
    Create Notification
</a>

        </div>
    </div>
    <!-- Notification Filters -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
    <form action="{{ route('notifications.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">

        <!-- User Filter -->
        <div>
            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">User</label>
            <select name="user_id" id="user_id" class="block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
                <option value="">All Users</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Target Type Filter -->
        <div>
            <label for="target_type" class="block text-sm font-medium text-gray-700 mb-1">Target Type</label>
            <select name="target_type" id="target_type" class="block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
                <option value="">All Types</option>
                <option value="system" {{ request('target_type') == 'system' ? 'selected' : '' }}>System</option>
                <option value="user" {{ request('target_type') == 'user' ? 'selected' : '' }}>User</option>
                <!-- Add more target types as needed -->
            </select>
        </div>

        <!-- Channel Filter -->
        <div>
            <label for="channel" class="block text-sm font-medium text-gray-700 mb-1">Channel</label>
            <select name="channel" id="channel" class="block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
                <option value="">All Channels</option>
                <option value="in-app" {{ request('channel') == 'in-app' ? 'selected' : '' }}>In-App</option>
                <option value="email" {{ request('channel') == 'email' ? 'selected' : '' }}>Email</option>
                <option value="both" {{ request('channel') == 'both' ? 'selected' : '' }}>Both</option>
            </select>
        </div>

        <!-- Time Filter -->
        <div>
            <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Older Than</label>
            <select name="time" id="time" class="block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
                <option value="">Any time</option>
                <option value="1_day" {{ request('time') == '1_day' ? 'selected' : '' }}>1 Day</option>
                <option value="1_week" {{ request('time') == '1_week' ? 'selected' : '' }}>1 Week</option>
                <option value="1_month" {{ request('time') == '1_month' ? 'selected' : '' }}>1 Month</option>
            </select>
        </div>

        <!-- Filter / Clear Buttons -->
        <div class="flex items-end space-x-2 mr-2">
            <a href="{{ route('notifications.index') }}" 
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

    <!-- Delete Button -->
    @if(request()->hasAny(['user_id', 'target_type', 'channel', 'time']))
    <form action="{{ route('notifications.bulkDelete') }}" method="POST" onsubmit="return confirm('Delete filtered notifications?')" class="mt-4">
        @csrf
        @method('DELETE')
        @foreach(request()->all() as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm">
            <i class="bi bi-trash3 mr-2"></i> Delete Filtered Notifications
        </button>
    </form>
    @endif
</div>


    <!-- Notifications Table -->
    <div class="bg-white rounded-xl shadow overflow-x-auto border border-gray-200">
       <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-3 font-medium">#</th>
                    <th class="px-4 py-3 font-medium">Title</th>
                    <th class="px-4 py-3 font-medium">Message</th>
                    <th class="px-4 py-3 font-medium">Target</th>
                    <th class="px-4 py-3 font-medium">Channel</th>
                    <th class="px-4 py-3 font-medium">Created At</th>
                    <th class="px-4 py-3 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($notifications as $index => $notification)
                    <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                        <td class="px-4 py-3">{{ $loop->iteration + ($notifications->currentPage() - 1) * $notifications->perPage() }}</td>
                        <td class="px-4 py-3 text-left truncate max-w-xs" title="">
                    {{ Str::limit($notification->title, 10,'') }}
                    @if(strlen($notification->title) > 10)
                        <a href="{{ route('notifications.show', $notification->id) }}" class="text-blue-600 hover:underline">...more</a>
                    @endif
                </td>
                        <td class="px-4 py-3 text-left truncate max-w-xs" title="">
                    {{ Str::limit($notification->message, 10,'...') }}
                    @if(strlen($notification->message) > 10)
                        <a href="{{ route('notifications.show', $notification->id) }}" class="text-blue-600 hover:underline">...more</a>
                    @endif
                </td>
                        <td class="px-4 py-3">
                            @if($notification->target_type === 'system')
                                <span class="inline-block bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full text-xs font-semibold">System-wide</span>
                            @else
                                <a href="{{ route('users.show', $notification->user) }}" class="text-blue-600 hover:underline">
                                    {{ $notification->user->first_name }} {{ $notification->user->last_name }}
                                </a>
                            @endif
                        </td>
                        <td class="px-4 py-3 capitalize">{{ str_replace('_', ' ', $notification->channel) }}</td>
                        <td class="px-4 py-3">{{ $notification->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="
                            {{ route('notifications.show', $notification) }}
                             " class="text-blue-500 hover:text-blue-600" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="
                            {{ route('notifications.edit', $notification) }}
                             " class="text-yellow-500 hover:text-yellow-600" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="
                            {{ route('notifications.destroy', $notification) }}
                            " method="POST" class="inline-block" onsubmit="return confirm('Delete this notification?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-6 text-center text-gray-500">No notifications found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $notifications->withQueryString()->links() }}
    </div>
</div>
@endsection
