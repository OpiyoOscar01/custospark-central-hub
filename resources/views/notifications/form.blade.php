<div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 flex items-center">
                <i class="bi bi-type-bold mr-2 text-gray-500"></i> Title
            </label>
            <input type="text" name="title" id="title"
                   value="{{ old('title', $notification->title ?? '') }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                   required>
        </div>

        {{-- Message --}}
        <div class="mb-4">
            <label for="message" class="block text-sm font-medium text-gray-700 flex items-center">
                <i class="bi bi-chat-left-text mr-2 text-gray-500"></i> Message
            </label>
            <textarea name="message" id="message"
                      rows="4"
                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                      required>{{ old('message', $notification->message ?? '') }}</textarea>
        </div>

        {{-- Target Type --}}
        <div class="mb-4">
            <label for="target_type" class="block text-sm font-medium text-gray-700 flex items-center">
                <i class="bi bi-bullseye mr-2 text-gray-500"></i> Target
            </label>
            <select name="target_type" id="target_type"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required>
                <option value="">Select target</option>
                <option value="system" {{ old('target_type', $notification->target_type ?? '') == 'system' ? 'selected' : '' }}>System-wide</option>
                <option value="user" {{ old('target_type', $notification->target_type ?? '') == 'user' ? 'selected' : '' }}>Specific User</option>
            </select>
        </div>

        {{-- User Selection (only if target is "user") --}}
        <div class="mb-4" id="user_id_field" style="display: none;">
            <label for="user_id" class="block text-sm font-medium text-gray-700 flex items-center">
                <i class="bi bi-person-lines-fill mr-2 text-gray-500"></i> User (if specific)
            </label>
            <select name="user_id" id="user_id"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">Select user</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $notification->user_id ?? '') == $user->id ? 'selected' : '' }}>
                        {{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Channel --}}
        <div class="mb-6">
            <label for="channel" class="block text-sm font-medium text-gray-700 flex items-center">
                <i class="bi bi-broadcast-pin mr-2 text-gray-500"></i> Channel
            </label>
            <select name="channel" id="channel"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required>
                <option value="in_app" {{ old('channel', $notification->channel ?? '') == 'in_app' ? 'selected' : '' }}>In-App</option>
                <option value="email" {{ old('channel', $notification->channel ?? '') == 'email' ? 'selected' : '' }}>Email</option>
                <option value="both" {{ old('channel', $notification->channel ?? '') == 'both' ? 'selected' : '' }}>Both</option>
            </select>
        </div>

        {{-- Submit --}}
        <div class="mt-6">
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none">
                <i class="bi bi-send mr-2"></i> Update Notification
            </button>
        </div>