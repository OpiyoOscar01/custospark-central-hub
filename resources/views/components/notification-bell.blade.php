<div class="relative" x-data="{ open: false }">
    <button type="button" @click="open = !open" class="relative p-2 text-gray-400 hover:text-gray-500">
        <span class="sr-only">View notifications</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
        @if($notifications->where('read_at', null)->count() > 0)
            <span class="absolute top-0 right-0 block h-4 w-4 rounded-full bg-red-500 text-xs text-white flex items-center justify-center">
                {{ $notifications->where('read_at', null)->count() }}
            </span>
        @endif
    </button>

    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
        <div class="p-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                @if($notifications->where('read_at', null)->count() > 0)
                    <form action="{{ route('notifications.mark-all-as-read') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-900">
                            Mark all as read
                        </button>
                    </form>
                @endif
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($notifications as $notification)
                    <div class="py-4 {{ is_null($notification->read_at) ? 'bg-blue-50' : '' }}">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $notification->data['title'] }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                            @if(is_null($notification->read_at))
                                <form action="{{ route('notifications.mark-as-read', $notification) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-900">
                                        Mark as read
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-4">
                        <p class="text-sm text-gray-500 text-center">No notifications</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>