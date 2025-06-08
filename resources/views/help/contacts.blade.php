@php
$layout=Auth::check() ? 'layouts.employee' : 'layouts.main';
@endphp

@extends($layout)
@section('title', 'Contact Us')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-blue-500 mb-6 bi bi-chat-dots mr-2"> Contact Us</h1>

    <div class="bg-white shadow-lg rounded-lg p-6 space-y-5">
        <div class="flex items-start">
            <i class="bi bi-geo-alt-fill text-indigo-600 text-xl mr-3 mt-1"></i>
            <div>
                <h2 class="font-semibold text-gray-700">Headquarters</h2>
                <p class="text-gray-600">{{ env('COMPANY_HQTS') }}</p>
            </div>
        </div>

        <div class="flex items-start">
            <i class="bi bi-envelope-fill text-indigo-600 text-xl mr-3 mt-1"></i>
            <div>
                <h2 class="font-semibold text-gray-700">Email</h2>
                <p class="text-gray-600">
                    <a href="mailto:{{ env('COMPANY_SUPPORT_EMAIL') }}" class="text-indigo-600 hover:underline">{{ env('COMPANY_SUPPORT_EMAIL') ?? 'NULL' }}</a>
                </p>
            </div>
        </div>

        <div class="flex items-start">
            <i class="bi bi-telephone-fill text-indigo-600 text-xl mr-3 mt-1"></i>
            <div>
                <h2 class="font-semibold text-gray-700">Phone</h2>
                <p class="text-gray-600">{{ env('COMPANY_SUPPORT_PHONE') }}</p>
            </div>
        </div>

        <div class="flex items-start">
            <i class="bi bi-mailbox2 text-indigo-600 text-xl mr-3 mt-1"></i>
            <div>
                <h2 class="font-semibold text-gray-700">Postal Address</h2>
                <p class="text-gray-600">{{ env('COMPANY_POSTAL_ADDRESS') ?? 'NULL' }}</p>
            </div>
        </div>

        <div class="flex items-start">
            <i class="bi bi-building text-indigo-600 text-xl mr-3 mt-1"></i>
            <div>
                <h2 class="font-semibold text-gray-700">Company Registration</h2>
                <p class="text-gray-600">
                  {{ env('COMPANY_REGISTRATION_NUMBER') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
