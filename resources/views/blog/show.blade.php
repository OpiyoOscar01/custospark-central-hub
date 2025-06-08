@php
    $layout = Auth::check() ? 'layouts.employee' : 'layouts.main';
@endphp

@extends($layout)
@section('title', $post->title)
@section('description', Str::limit(strip_tags($post->content), 150))
{{-- @section('keywords', implode(',', $post->tags->pluck('name')->toArray())) --}}
@section('author', $post->author->name)
@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-2 max-w-full mx-auto">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="mb-8 flex items-center space-x-2 text-sm text-blue-500">
            <a href="{{route('blog.guest.user') }}" class="hover:text-blue-500">All Updates</a>
            <i class="bi bi-chevron-right text-xs"></i>
            <span class="text-gray-900">{{ $post->title }}</span>
        </nav>

        <!-- Blog Post -->
        <article class="container-fluid bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden">
            @if($post->featured_image)
                <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" 
                     class="w-full h-64 object-cover">
            @endif
            
            <div class="p-6">
                <!-- Post Header -->
                <div class="mb-6">
                    <div class="flex items-center gap-2 text-sm text-blue-500 mb-3">
                        <span>{{ $post->published_at->format('M d, Y') }}</span>
                        <span>•</span>
                        <a href="#" 
                           class="text-blue-600 hover:text-blue-800">
                            {{ $post->category->name }}
                        </a>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
               <div class="flex items-center space-x-4">
    <div class="relative">
        <img 
            src="{{ $post->author->avatar_url 
                ? asset('storage/' . $post->author->avatar_url) 
                : 'https://ui-avatars.com/api/?name=' . urlencode($post->author->first_name . ' ' . $post->author->last_name) }}" 
            alt="Author Photo" 
            class="h-10 w-10 rounded-full border border-gray-300 object-cover"
        >
        <span class="absolute bottom-0 right-0 h-2.5 w-2.5 rounded-full 
            {{ Auth::check() && Auth::id() === $post->author->id ? 'bg-green-500 animate-pulse' : 'bg-gray-400' }} 
            ring-2 ring-white">
        </span>
    </div>

    <div>
        <div class="text-sm font-medium text-gray-900 flex items-center gap-2">
            {{ $post->author->first_name }} {{ $post->author->last_name }}
            @if(Auth::check() && Auth::id() === $post->author->id)
                <span class="text-xs text-green-500">(You)</span>
            @endif
        </div>
        <div class="text-sm text-blue-500">Author</div>
    </div>
</div>

                    
                </div>

                <!-- Post Content -->
                <div class="prose max-w-none mb-8">
                    {!! $post->content !!}
                </div>

                <!-- Reactions -->
        <div class="flex items-center space-x-4 mb-8 border-t border-b border-gray-200 py-4">
                {{-- LIKE --}}
                @auth
                    @php
                        $hasLiked = auth()->user()?->hasReacted($post, 'like');
                    @endphp
                    <form action="{{ $hasLiked ? route('posts.unreact', $post) : route('posts.react', $post) }}" method="POST" class="inline">
                        @csrf
                        @if($hasLiked)
                            @method('DELETE')
                        @else
                            <input type="hidden" name="type" value="like" />
                        @endif
                        <button type="submit" 
                            class="flex items-center space-x-2 px-4 py-2 rounded-lg
                                {{ $hasLiked ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                            <i class="bi bi-hand-thumbs-up"></i>
                            <span class="like-count">{{ $post->reactions()->where('type', 'like')->count() }}</span>
                        </button>
                    </form>
                @else
                    <div class="flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-500 bg-gray-50 cursor-not-allowed">
                        <i class="bi bi-hand-thumbs-up"></i>
                        <span class="like-count">{{ $post->reactions()->where('type', 'like')->count() }}</span>
                        <a href="{{ route('login') }}" class="ml-2 text-sm text-blue-600 hover:underline">(Login to react)</a>
                    </div>
                @endauth

                {{-- DISLIKE --}}
                @auth
                    @php
                        $hasDisliked = auth()->user()?->hasReacted($post, 'dislike');
                    @endphp
                    <form action="{{ $hasDisliked ? route('posts.unreact', $post) : route('posts.react', $post) }}" method="POST" class="inline">
                        @csrf
                        @if($hasDisliked)
                            @method('DELETE')
                        @else
                            <input type="hidden" name="type" value="dislike" />
                        @endif
                        <button type="submit" 
                            class="flex items-center space-x-2 px-4 py-2 rounded-lg
                                {{ $hasDisliked ? 'bg-red-100 text-red-700' : 'hover:bg-gray-100' }}">
                            <i class="bi bi-hand-thumbs-down"></i>
                            <span class="dislike-count">{{ $post->reactions()->where('type', 'dislike')->count() }}</span>
                        </button>
                    </form>
                @else
                    <div class="flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-500 bg-gray-50 cursor-not-allowed">
                        <i class="bi bi-hand-thumbs-down"></i>
                        <span class="dislike-count">{{ $post->reactions()->where('type', 'dislike')->count() }}</span>
                        <a href="{{ route('login') }}" class="ml-2 text-sm text-blue-600 hover:underline">(Login to react)</a>
                    </div>
                @endauth
            </div>



                <!-- Comments Section -->
                <div class="space-y-6">
                    <h2 class="text-xl font-bold text-gray-900">Comments ({{ $post->comments->count() }})</h2>

                    @auth
                        <!-- Comment Form -->
                        <form action="{{ route('blog.comments.store', $post) }}" method="POST" class="mb-8">
                            @csrf
                            <div class="mb-4">
                                <label for="content" class="sr-only">Comment</label>
                                <textarea id="content" name="content" rows="3" 
                                          class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Leave a comment..."
                                          required></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Post Comment
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-gray-600">Please <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">log in</a> to leave a comment.</p>
                        </div>
                    @endauth

                    <!-- Comments List -->
                  <div class="space-y-6">
                    @forelse($post->comments()->latest()->get() as $comment)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <img
                                        src="{{ $comment->user->avatar_url 
                                            ? asset('storage/' . $comment->user->avatar_url) 
                                            : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->first_name . ' ' . $comment->user->last_name) }}"
                                        alt="{{ $comment->user->first_name }} {{ $comment->user->last_name }}"
                                        class="h-8 w-8 rounded-full object-cover border border-gray-300"
                                    />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-medium text-gray-900">{{ $comment->user->first_name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="mt-1 text-sm text-gray-700">
                                        <p>{{ $comment->content }}</p>
                                    </div>
                                    @can('update', $comment)
                                        <div class="mt-2 flex items-center space-x-2">
                                            <button type="button" 
                                                    class="text-sm text-blue-600 hover:text-blue-800"
                                                    onclick="editComment('{{ $comment->id }}')">
                                                Edit
                                            </button>
                                            <form action="{{ route('blog.comments.delete', $comment) }}" 
                                                method="POST" 
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">No comments yet. Be the first to comment!</p>
                    @endforelse
                </div>

                </div>
            </div>
        </article>
    </div>
</div>
@endsection
@section('scripts')


@endsection