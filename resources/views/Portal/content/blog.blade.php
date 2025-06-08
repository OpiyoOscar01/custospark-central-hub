@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Blog Management</span>
    </nav>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                        <i class="bi bi-journal-text text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Blog Posts</h1>
                        <p class="mt-1 text-sm text-gray-500">Manage your blog content and publications</p>
                    </div>
                </div>
                <a href="#" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="bi bi-plus-lg mr-2"></i>
                    New Post
                </a>
            </div>
        </div>

        <div class="p-6">
            <!-- Search and Filters -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="relative">
                    <input type="text" 
                           placeholder="Search posts..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="bi bi-search text-gray-400"></i>
                    </div>
                </div>
                <div class="flex space-x-4">
                    <select class="block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Blog Posts Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{-- @forelse($posts as $post)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $post->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $post->category->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $post->author->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $post->published_at->format('M d, Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="bi bi-pencil"></i>
                                            <span class="sr-only">Edit</span>
                                        </a>
                                        <form action="#" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this post?')">
                                                <i class="bi bi-trash"></i>
                                                <span class="sr-only">Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty --}}
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    <div class="flex flex-col items-center py-8">
                                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                                            <i class="bi bi-journal-text text-2xl text-blue-600"></i>
                                        </div>
                                        <h3 class="text-sm font-medium text-gray-900">No Posts Found</h3>
                                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new blog post.</p>
                                        <div class="mt-4">
                                            <a href="#" 
                                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                                                <i class="bi bi-plus-lg mr-2"></i>
                                                Create Post
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        {{-- @endforelse --}}
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{-- @if($posts->hasPages())
                <div class="border-t border-gray-200 px-6 py-4">
                    {{ $posts->links() }}
                </div>
            @endif --}}
        </div>
    </div>

    <!-- Blog Statistics -->
    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
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
                            <dd class="mt-1 text-2xl font-bold text-gray-900">0</dd>
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
                            <dd class="mt-1 text-2xl font-bold text-gray-900">0</dd>
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
                            <dd class="mt-1 text-2xl font-bold text-gray-900">0</dd>
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
                            <dd class="mt-1 text-2xl font-bold text-gray-900">0</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Handle New Post Form
    const newPostForm = document.getElementById('blogForm');
    const openNewFormBtn = document.getElementById('openFormBtn');
    const closeNewFormBtn = document.getElementById('closeFormBtn');

    if (openNewFormBtn && newPostForm) {
      openNewFormBtn.addEventListener('click', function (e) {
        e.preventDefault();
        newPostForm.classList.remove('hidden'); // Show New Post Form
      });
    }

    if (closeNewFormBtn && newPostForm) {
      closeNewFormBtn.addEventListener('click', function () {
        newPostForm.classList.add('hidden'); // Hide New Post Form
      });
    }

    // Handle Edit Forms
    document.querySelectorAll('[data-edit-btn]').forEach(function (editBtn) {
      editBtn.addEventListener('click', function (e) {
        e.preventDefault();
        const postId = this.dataset.postId;
        const editForm = document.getElementById(`edit-form-${postId}`);

        // Hide all other open edit forms
        document.querySelectorAll("[id^='edit-form-']").forEach(function (form) {
          form.classList.add('hidden');
        });

        // Show the selected edit form
        if (editForm) {
          editForm.classList.remove('hidden');
          editForm.scrollIntoView({ behavior: 'smooth' });
        }
      });
    });

    // Handle Edit Form Close Buttons
    document.querySelectorAll('.close-edit-form-btn').forEach(function (closeBtn) {
      closeBtn.addEventListener('click', function () {
        const postId = this.dataset.postId;
        const editForm = document.getElementById(`edit-form-${postId}`);
        if (editForm) {
          editForm.classList.add('hidden'); // Hide Edit Form
        }
      });
    });
  });
  
  // Hide the success message after 5 seconds
  setTimeout(function() {
        var successMessage = document.getElementById('success-message');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 5000);

    // Hide the error message after 5 seconds
    setTimeout(function() {
        var errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            errorMessage.style.display = 'none';
        }
    }, 5000);

    // Hide the warning message after 5 seconds
    setTimeout(function() {
        var warningMessage = document.getElementById('warning-message');
        if (warningMessage) {
            warningMessage.style.display = 'none';
        }
    }, 5000);

    // Hide the info message after 5 seconds
    setTimeout(function() {
        var infoMessage = document.getElementById('info-message');
        if (infoMessage) {
            infoMessage.style.display = 'none';
        }
    }, 5000);
</script>
<script>
    // Show the post details when the "See more" button is clicked
    document.querySelectorAll('.view-post-btn').forEach(function(button) {
      button.addEventListener('click', function(event) {
        event.preventDefault();
        
        // Get the post details from data attributes
        const postId = button.getAttribute('data-post-id');
        const title = button.getAttribute('data-title');
        const author = button.getAttribute('data-author');
        const category = button.getAttribute('data-category');
        const content = button.getAttribute('data-content');
  
        // Set the post details in the hidden div
        document.getElementById('post-title-' + postId).textContent = title;
        document.getElementById('post-author-' + postId).textContent = 'Author: ' + author;
        document.getElementById('post-category-' + postId).textContent = 'Category: ' + category;
        document.getElementById('post-content-' + postId).textContent = content;
  
        // Show the hidden details div
        document.getElementById('post-details-' + postId).classList.remove('hidden');
      });
    });
  
    // Close the post details when the "Close" button is clicked
    document.querySelectorAll('.close-details-btn').forEach(function(button) {
      button.addEventListener('click', function() {
        const postId = button.getAttribute('data-post-id');
        
        // Hide the post details div
        document.getElementById('post-details-' + postId).classList.add('hidden');
      });
    });
  </script>
