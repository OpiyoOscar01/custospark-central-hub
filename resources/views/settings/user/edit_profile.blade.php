@extends('layouts.employee')

@section('content')
<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <a href="{{ route('user.profile.show', $user->id) }}" class="hover:text-gray-700">My Profile</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Edit</span>
    </nav>

    {{-- Profile Edit Form --}}
    <form method="POST" action="{{ route('user.profile.update', $user->id) }}" enctype="multipart/form-data" class="bg-white border border-gray-200 shadow-sm rounded-2xl overflow-hidden">
        @csrf
        @method('PUT')

        {{-- Header with Avatar --}}
        <div class="flex items-center gap-4 p-6 border-b border-gray-100">
            <div class="relative">
                <img src="{{ $user->avatar_url ? asset('storage/' . $user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->first_name . ' ' . $user->last_name) }}"
                     class="h-16 w-16 rounded-full object-cover border"
                     alt="User Avatar">

                <label for="avatar" class="absolute -bottom-2 -right-2 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-1 shadow cursor-pointer">
                    <i class="bi bi-camera text-xs"></i>
                </label>
                <input id="avatar" name="avatar" type="file" class="hidden" accept="image/*">
                @error('avatar')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <h1 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="bi bi-pencil-square text-blue-600"></i>
                    Editing Profile: {{ $user->first_name }} {{ $user->last_name }}
                </h1>
                <p class="text-sm text-gray-600">{{ $user->email }}</p>
            </div>
        </div>

        {{-- Identity Section --}}
        <div class="p-6 space-y-6">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-card-text text-blue-500"></i> Identity
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- First Name --}}
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input id="first_name" name="first_name" type="text" value="{{ old('first_name', $user->first_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('first_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Last Name --}}
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input id="last_name" name="last_name" type="text" value="{{ old('last_name', $user->last_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('last_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Phone --}}
               <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input
                    id="phone"
                    name="phone"
                    type="text"
                    value="{{ old('phone', $user->phone) }}"
                    placeholder="e.g. +256-700-123456"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                >
                @error('phone')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>


                {{-- Sex --}}
                <div>
                    <label for="sex" class="block text-sm font-medium text-gray-700">Sex</label>
                    <select name="sex" id="sex" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Select</option>
                        <option value="male" {{ old('sex', $user->sex) === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('sex', $user->sex) === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('sex', $user->sex) === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('sex') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Date of Birth --}}
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth', $user->date_of_birth) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('date_of_birth') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Location Section --}}
        <div class="p-6 border-t border-gray-100 space-y-6">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-geo-alt text-blue-500"></i> Location &amp; Language
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Country --}}
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                    <input id="country" name="country" type="text" value="{{ old('country', $user->country) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('country') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- City --}}
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                    <input id="city" name="city" type="text" value="{{ old('city', $user->city) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('city') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Address --}}
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input id="address" name="address" type="text" value="{{ old('address', $user->address) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('address') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Language --}}
                <div>
                    <label for="language" class="block text-sm font-medium text-gray-700">Language</label>
                    <input id="language" name="language" type="text" value="{{ old('language', $user->language) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('language') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Timezone --}}
               @php
    $timezones = DateTimeZone::listIdentifiers();
@endphp

{{-- Timezone --}}
<div>
    <label for="timezone" class="block text-sm font-medium text-gray-700">Timezone</label>
    <select
        id="timezone"
        name="timezone"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
    >
        @foreach($timezones as $tz)
            <option value="{{ $tz }}" {{ old('timezone', $user->timezone) === $tz ? 'selected' : '' }}>
                {{ $tz }}
            </option>
        @endforeach
    </select>
    @error('timezone')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

            </div>
        </div>

        {{-- Personal Info Section --}}
        <div class="p-6 border-t border-gray-100 space-y-6">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-person-vcard text-blue-500"></i> Personal Info
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Bio --}}
                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                    <textarea id="bio" name="bio" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Website --}}@extends('layouts.employee')

@section('content')
<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center space-x-2 text-sm text-gray-500" aria-label="Breadcrumb">
        <a href="{{ route('dashboard') }}" class="hover:text-gray-700 flex items-center gap-1">
            <i class="bi bi-house-door-fill"></i> Dashboard
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <a href="{{ route('user.profile.show', $user->id) }}" class="hover:text-gray-700 flex items-center gap-1">
            <i class="bi bi-person-circle"></i> My Profile
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900 flex items-center gap-1" aria-current="page">
            <i class="bi bi-pencil-square"></i> Edit
        </span>
    </nav>

    {{-- Profile Edit Form --}}
    <form method="POST" action="{{ route('user.profile.update', $user->id) }}" enctype="multipart/form-data"
        class="bg-white border border-gray-200 shadow-sm rounded-2xl overflow-hidden"
        aria-label="Edit Profile Form"
    >
        @csrf
        @method('PUT')

        {{-- Header with Avatar and User Info --}}
        <div class="flex items-center gap-4 p-6 border-b border-gray-100">
            <div class="relative">
                <img
                    src="{{ $user->avatar_url ? asset('storage/' . $user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->first_name . ' ' . $user->last_name) }}"
                    alt="User Avatar"
                    class="h-16 w-16 rounded-full object-cover border"
                >

                <label for="avatar" class="absolute -bottom-2 -right-2 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-1 shadow cursor-pointer" title="Change avatar">
                    <i class="bi bi-camera text-xs"></i>
                </label>
                <input id="avatar" name="avatar" type="file" class="hidden" accept="image/*">
                @error('avatar')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <h1 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="bi bi-pencil-square text-blue-600"></i>
                    Editing Profile: {{ $user->first_name }} {{ $user->last_name }}
                </h1>
                <p class="text-sm text-gray-600 truncate max-w-xs">{{ $user->email }}</p>
            </div>
        </div>

        {{-- Identity Section --}}
        <section class="p-6 space-y-6" aria-labelledby="identity-section">
            <h2 id="identity-section" class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-card-text text-blue-500"></i> Identity
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- First Name --}}
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input id="first_name" name="first_name" type="text"
                        value="{{ old('first_name', $user->first_name) }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        required
                    >
                    @error('first_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Last Name --}}
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input id="last_name" name="last_name" type="text"
                        value="{{ old('last_name', $user->last_name) }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        required
                    >
                    @error('last_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input id="phone" name="phone" type="text" placeholder="+256-700-123456"
                        value="{{ old('phone', $user->phone) }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                    @error('phone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Sex --}}
                <div>
                    <label for="sex" class="block text-sm font-medium text-gray-700">Sex</label>
                    <select id="sex" name="sex"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                        <option value="" {{ old('sex', $user->sex) === '' ? 'selected' : '' }}>Select</option>
                        <option value="male" {{ old('sex', $user->sex) === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('sex', $user->sex) === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('sex', $user->sex) === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('sex') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Date of Birth --}}
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input id="date_of_birth" name="date_of_birth" type="date"
                        value="{{ old('date_of_birth', $user->date_of_birth) }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                    @error('date_of_birth') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </section>

        {{-- Location & Language Section --}}
        <section class="p-6 border-t border-gray-100 space-y-6" aria-labelledby="location-section">
            <h2 id="location-section" class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-geo-alt text-blue-500"></i> Location &amp; Language
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Country --}}
            <div>
    <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
    <input id="country" name="country" type="text"
        value="{{ old('country', $user->country) }}"
        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
    >
    @error('country') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

<div class="mt-4">
    <label for="preferred_currency" class="block text-sm font-medium text-gray-700">Preferred Currency</label>
    <select id="preferred_currency" name="preferred_currency"
        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        @php
            $currencies = [
                'USD' => 'US Dollar',
                'EUR' => 'Euro',
                'GBP' => 'British Pound',
                'NGN' => 'Nigerian Naira',
                'KES' => 'Kenyan Shilling',
                'UGX' => 'Ugandan Shilling',
                'GHS' => 'Ghanaian Cedi',
                'ZAR' => 'South African Rand',
                'TZS' => 'Tanzanian Shilling',
                'MWK' => 'Malawian Kwacha',
                'SLL' => 'Sierra Leonean Leone',
                'XAF' => 'Central African CFA Franc',
                'XOF' => 'West African CFA Franc',
                'GNF' => 'Guinean Franc',
                'MAD' => 'Moroccan Dirham',
                'MUR' => 'Mauritian Rupee',
                'ZMW' => 'Zambian Kwacha',
                'RWF' => 'Rwandan Franc',
                'ETB' => 'Ethiopian Birr',
                'INR' => 'Indian Rupee',
                'JPY' => 'Japanese Yen',
                'CAD' => 'Canadian Dollar',
                'AUD' => 'Australian Dollar',
                'NZD' => 'New Zealand Dollar',
                'CHF' => 'Swiss Franc',
                'NOK' => 'Norwegian Krone',
                'PLN' => 'Polish Zloty',
                'CZK' => 'Czech Koruna',
                'ILS' => 'Israeli Shekel',
                'ARS' => 'Argentine Peso',
                'PEN' => 'Peruvian Sol',
                'MYR' => 'Malaysian Ringgit',
                'RUB' => 'Russian Ruble',
                'AED' => 'Emirati Dirham',
            ];
        @endphp
        @foreach ($currencies as $code => $label)
            <option value="{{ $code }}" @selected(old('currency', $user->currency) === $code)>
                {{ $label }} ({{ $code }})
            </option>
        @endforeach
    </select>
    @error('preferred_currency') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>


                {{-- City --}}
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                    <input id="city" name="city" type="text"
                        value="{{ old('city', $user->city) }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                    @error('city') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Address --}}
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input id="address" name="address" type="text"
                        value="{{ old('address', $user->address) }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                    @error('address') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Language --}}
                <div>
                    <label for="language" class="block text-sm font-medium text-gray-700">Language</label>
                    <input id="language" name="language" type="text"
                        value="{{ old('language', $user->language) }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                    @error('language') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Timezone --}}
                @php
                    $timezones = DateTimeZone::listIdentifiers();
                @endphp
                <div>
                    <label for="timezone" class="block text-sm font-medium text-gray-700">Timezone</label>
                    <select id="timezone" name="timezone"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                        @foreach($timezones as $tz)
                            <option value="{{ $tz }}" {{ old('timezone', $user->timezone) === $tz ? 'selected' : '' }}>
                                {{ $tz }}
                            </option>
                        @endforeach
                    </select>
                    @error('timezone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </section>

        {{-- Personal Info Section --}}
        <section class="p-6 border-t border-gray-100 space-y-6" aria-labelledby="personal-info-section">
            <h2 id="personal-info-section" class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-person-vcard text-blue-500"></i> Personal Info
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Bio --}}
                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                    <textarea id="bio" name="bio" rows="3"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >{{ old('bio', $user->bio) }}</textarea>
                    @error('bio') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Website --}}
                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                    <input id="website" name="website" type="url"
                        value="{{ old('website', $user->website) }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                    @error('website') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </section>

        {{-- Submit Button --}}
        <div class="px-6 py-4 border-t border-gray-100 flex justify-end bg-gray-50">
            <button type="submit"
                class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                <i class="bi bi-check-lg mr-2"></i> Save Changes
            </button>
        </div>

    </form>
</div>
@endsection

                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                    <input id="website" name="website" type="text" value="{{ old('website', $user->website) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('website') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Save Button --}}
        <div class="px-6 py-4 border-t border-gray-100 flex justify-end bg-gray-50">
            <button type="submit" class="inline-flex items-center px-5 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full shadow-sm transition">
                <i class="bi bi-save mr-2"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
