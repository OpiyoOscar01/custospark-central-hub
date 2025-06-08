@extends('layouts.employee')

@section('content')
<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('users.index') }}" class="hover:text-gray-700">Users</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</span>
    </nav>

    {{-- Main Card --}}
    <div class="bg-white border border-gray-200 shadow-sm rounded-2xl overflow-hidden">

        {{-- Header --}}
        <div class="flex items-center gap-4 p-6 border-b border-gray-100">
            <img src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->first_name . ' ' . $user->last_name) }}" class="h-16 w-16 rounded-full object-cover border" alt="User Avatar">
            <div>
                <h1 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="bi bi-person-fill text-blue-600"></i>
                    {{ $user->first_name }} {{ $user->last_name }}
                </h1>
                <div class="text-sm text-gray-600">{{ $user->email }}</div>
                <div class="mt-1">
                    <span class="inline-block text-xs px-2 py-1 rounded-full font-medium {{ $user->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $user->status ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Section: Identity --}}
        <div class="p-6 space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-card-text text-blue-500"></i> Identity
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><strong>Profile URL:</strong> {{ $user->profile_url ?? '—' }}</div>
                <div><strong>Phone:</strong> {{ $user->phone ?? '—' }}</div>
                <div><strong>Sex:</strong> {{ ucfirst($user->sex) ?? '—' }}</div>
                <div><strong>Date of Birth:</strong> {{ $user->date_of_birth ?? '—' }}</div>
            </div>
        </div>

        {{-- Section: Login Activity --}}
        <div class="p-6 border-t border-gray-100 space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-clock-history text-blue-500"></i> Login Activity
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><strong>Last Login:</strong> {{ $user->last_login_at ?? '—' }}</div>
                <div><strong>Login IP:</strong> {{ $user->last_login_ip ?? '—' }}</div>
                <div><strong>Password Changed At:</strong> {{ $user->password_changed_at ?? '—' }}</div>
            </div>
        </div>

        {{-- Section: Location & Language --}}
        <div class="p-6 border-t border-gray-100 space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-geo-alt text-blue-500"></i> Location & Language
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><strong>Country:</strong> {{ $user->country ?? '—' }}</div>
                <div><strong>State:</strong> {{ $user->state ?? '—' }}</div>
                <div><strong>City:</strong> {{ $user->city ?? '—' }}</div>
                <div><strong>Postal Code:</strong> {{ $user->postal_code ?? '—' }}</div>
                <div class="md:col-span-2"><strong>Address:</strong> {{ $user->address ?? '—' }}</div>
                <div><strong>Timezone:</strong> {{ $user->timezone ?? '—' }}</div>
                <div><strong>Language:</strong> {{ $user->language ?? '—' }}</div>
            </div>
        </div>

        {{-- Section: Personal Bio --}}
        <div class="p-6 border-t border-gray-100 space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-person-vcard text-blue-500"></i> Personal Info
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><strong>Bio:</strong> {{ $user->bio ?? '—' }}</div>
                <div><strong>Website:</strong> {{ $user->website ?? '—' }}</div>
            </div>
        </div>

        {{-- Section: Social Links --}}
        <div class="p-6 border-t border-gray-100 space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-share-fill text-blue-500"></i> Social Accounts
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><strong>Google ID:</strong> {{ $user->google_id ?? '—' }}</div>
                <div><strong>Facebook ID:</strong> {{ $user->facebook_id ?? '—' }}</div>
                <div><strong>Twitter ID:</strong> {{ $user->twitter_id ?? '—' }}</div>
            </div>
        </div>

        {{-- Section: 2FA --}}
        <div class="p-6 border-t border-gray-100 space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-shield-lock-fill text-blue-500"></i> Two-Factor Authentication
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><strong>2FA Enabled:</strong> {{ $user->two_factor_enabled ? 'Yes' : 'No' }}</div>
                <div><strong>2FA Secret:</strong> {{ $user->two_factor_secret ? '********' : '—' }}</div>
            </div>
        </div>

        {{-- Section: Marketing Preferences --}}
        <div class="p-6 border-t border-gray-100 space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-envelope-paper-fill text-blue-500"></i> Marketing Preferences
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><strong>Newsletter Opt-in:</strong> {{ $user->newsletter_opt_in ? 'Yes' : 'No' }}</div>
                <div><strong>Marketing Opt-in:</strong> {{ $user->marketing_opt_in ? 'Yes' : 'No' }}</div>
            </div>
        </div>

        {{-- Section: Audit --}}
        <div class="p-6 border-t border-gray-100 space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-activity text-blue-500"></i> Audit Trail
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><strong>Created By:</strong> {{ $user->created_by ?? '—' }}</div>
                <div><strong>Updated By:</strong> {{ $user->updated_by ?? '—' }}</div>
                <div><strong>Deleted By:</strong> {{ $user->deleted_by ?? '—' }}</div>
                <div><strong>Approved By:</strong> {{ $user->approved_by ?? '—' }}</div>
            </div>
        </div>

        {{-- Section: Roles by App --}}
        <div class="p-6 border-t border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2 mb-3">
                <i class="bi bi-diagram-3 text-blue-500"></i> Roles by Application
            </h2>
            @forelse($rolesByApp as $appName => $roles)
                <div class="mb-4">
                    <h3 class="text-indigo-700 font-semibold">{{ $appName }}</h3>
                    <ul class="list-disc pl-6 text-sm text-gray-800">
                        @foreach($roles as $role)
                            <li>{{ ucfirst($role->name) }}</li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <p class="text-gray-500 italic">No roles assigned.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
