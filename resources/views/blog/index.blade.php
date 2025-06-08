@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Blog Management</span>
    </nav>

    <!-- Blog Statistics -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Posts -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
            <div class="p-5">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="bg-blue-100 text-blue-600 rounded-xl p-3 border border-blue-200">
                            <i class="bi bi-file-text text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Posts</dt>
                            <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['total'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Published Posts -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
            <div class="p-5">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="bg-green-100 text-green-600 rounded-xl p-3 border border-green-200">
                            <i class="bi bi-check-circle text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Published</dt>
                            <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['published'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Draft Posts -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
            <div class="p-5">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="bg-yellow-100 text-yellow-600 rounded-xl p-3 border border-yellow-200">
                            <i class="bi bi-pencil-square text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Drafts</dt>
                            <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['draft'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Views -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
            <div class="p-5">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="bg-purple-100 text-purple-600 rounded-xl p-3 border border-purple-200">
                            <i class="bi bi-eye text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Views</dt>
                            <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['views'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200 mt-8">
        <!-- Header -->
      <div class="p-6 border-b border-gray-200">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
            <div class="bg-blue-100 p-2 rounded-lg border border-blue-200 self-start sm:self-auto">
                <i class="bi bi-journal-text text-blue-600 text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Blog Posts</h1>
                <p class="mt-1 text-sm text-gray-500">Manage your blog content and publications</p>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-3 gap-2 sm:gap-0">
            <a href="{{ route('blog.categories.index') }}"
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                <i class="bi bi-folder mr-2"></i>
                Manage Categories
            </a>
            <a href="{{ route('blog.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700">
                <i class="bi bi-plus-lg mr-2"></i>
                New Post
            </a>
        </div>
    </div>
</div>


        <div class="p-6">
            <!-- Search and Filters -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="relative">
                    <input type="text" 
                           placeholder="Search posts..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="bi bi-search text-gray-400"></i>
                    </div>
                </div>
                <div>
                    <select class="block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select class="block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>
            </div>

            <!-- Blog Posts Table -->
            <div class="overflow-x-auto rounded-lg shadow-sm">
    <table class="min-w-full bg-white text-sm text-left text-gray-700">
        <thead class="bg-gray-100 text-xs font-semibold uppercase text-gray-600">
            <tr>
                <th class="px-6 py-3">Title</th>
                <th class="px-6 py-3">Category</th>
                <th class="px-6 py-3">Author</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Views</th>
                <th class="px-6 py-3">Published</th>
                <th class="px-6 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
                <tr class="hover:bg-gray-50 border-b last:border-b-0">
                    <td class="px-6 py-4">{{ $post->title }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $post->category->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $post->author->name }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium
                            @if($post->status === 'published') bg-green-100 text-green-800
                            @elseif($post->status === 'draft') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($post->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $post->views_count }}</td>
                    <td class="px-6 py-4 text-gray-500">
                        {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Not published' }}
                    </td>
                    <td class="px-6 py-4 text-right space-x-3">
                        <a href="{{ route('blog.edit', $post) }}" class="text-indigo-600 hover:text-indigo-900">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="{{ route('blog.show', $post) }}" class="text-indigo-600 hover:text-indigo-900">
                            <i class="bi bi-eye"></i>
                        </a>
                        @if($post->status === 'draft')
                            <form action="{{ route('blog.publish', $post) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-green-600 hover:text-green-900">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            </form>
                        @elseif($post->status === 'published')
                            <form action="{{ route('blog.unpublish', $post) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                    <i class="bi bi-pause-circle"></i>
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('blog.delete', $post) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this post?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                        <div class="flex flex-col items-center space-y-2">
                            <div class="h-12 w-12 flex items-center justify-center rounded-full bg-blue-100">
                                <i class="bi bi-journal-text text-2xl text-blue-600"></i>
                            </div>
                            <h3 class="text-sm font-medium text-gray-900">No Posts Found</h3>
                            <p class="text-sm text-gray-500">Get started by creating a new blog post.</p>
                            <a href="{{ route('blog.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700">
                                <i class="bi bi-plus-lg mr-2"></i> Create Post
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


            <!-- Pagination -->
            @if($posts->hasPages())
                <div class="border-t border-gray-200 px-6 py-4">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection