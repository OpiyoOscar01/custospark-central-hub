@extends('layouts.employee')


@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    @include('blog.partials.breadcrumb', ['title' => 'Create Post'])

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

@endif
    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        @include('blog.partials.header', ['title' => 'Create New Post', 'icon' => 'plus-circle'])

        <div class="p-6">
            <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                @include('blog.partials.form-fields')

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('blog.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="bi bi-x-lg mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="bi bi-check-lg mr-2"></i>
                        Create Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection