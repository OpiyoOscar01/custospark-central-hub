@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

    <!-- Enhanced Breadcrumb -->
    <nav class="mb-6 flex items-center space-x-2 text-sm text-gray-500">
        <span class="text-blue-500 font-medium">Your Products</span>
    </nav>

    <!-- Header: Discover What’s Possible -->
    <div class="mb-10 bg-white shadow-md rounded-lg p-6 border border-gray-200 text-center">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-center gap-4">
            <div class="bg-indigo-100 p-3 rounded-full w-fit mx-auto sm:mx-0">
                <i class="bi bi-lightbulb text-indigo-600 text-3xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Discover What’s Possible</h1>
                <p class="text-gray-600 mt-1">Explore smart plans tailored to your growth and manage your billing with ease.</p>
            </div>
        </div>
    </div>

    @php
        $apps = App\Models\App::all(); // Fetch all apps associated with the user
    @endphp

    <!-- Responsive Grid of Pricing Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($apps as $app)
            <div class="bg-white border border-gray-200 shadow rounded-xl p-6 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="bi bi-box-seam text-blue-600 mr-2"></i> {{ $app->name }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $app->description }}</p>
                </div>
                <div class="mt-auto pt-4">
                    <a href="{{ route('dashboard.pricing.app', ['app' => $app->id]) }}"
                       class="block w-full text-center text-sm text-white bg-blue-600 hover:bg-blue-700 font-medium px-4 py-2 rounded">
                        View Plans
                    </a>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
