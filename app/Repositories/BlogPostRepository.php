<?php

namespace App\Repositories;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class BlogPostRepository
{
    public function getAllPosts(int $perPage = 10): LengthAwarePaginator
    {
        return BlogPost::with(['category', 'author'])
            ->latest()
            ->where('author_id', Auth::id())
            ->paginate($perPage);
    }

    public function getPublishedPosts(int $perPage = 10): LengthAwarePaginator
    {
        return BlogPost::with(['category', 'author'])
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->where('author_id', Auth::id())
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function getAllPublishedPosts(int $perPage = 10): LengthAwarePaginator
    {
        return BlogPost::with(['category', 'author'])
            ->where('status', 'published')
            // ->where('published_at', '<=', now())
            ->latest('created_at')
            ->paginate($perPage);
    }
    public function getPublishedPostsForGuests(int $perPage = 10): LengthAwarePaginator
    {
        return BlogPost::with(['category', 'author'])
            ->where('status', 'published')
            // ->where('published_at', '<=', now())
            ->latest('created_at')
            ->paginate($perPage);
    }

    public function getPostsByCategory(BlogCategory $category, int $perPage = 10): LengthAwarePaginator
    {
        return $category->posts()
            ->with(['author'])
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->latest('created_at')
            ->paginate($perPage);
    }

    public function findBySlug(string $slug): ?BlogPost
    {
        return BlogPost::where('slug', $slug)
            ->with(['category', 'author', 'comments.user'])
            ->firstOrFail();
    }

    public function getRelatedPosts(BlogPost $post, int $limit = 3): Collection
    {
        return BlogPost::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->latest('created_at')
            ->limit($limit)
            ->get();
    }

    public function getPopularPosts(int $limit = 5): Collection
    {
        return BlogPost::where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderBy('views_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function searchPosts(string $query, int $perPage = 10): LengthAwarePaginator
    {
        return BlogPost::with(['category', 'author'])
            ->where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->latest()
            ->paginate($perPage);
    }

    public function getPostStats(): array
    {
        $authorId = Auth::id();

        return [
            'total' => BlogPost::where('author_id', $authorId)->count(),
            'published' => BlogPost::where('author_id', $authorId)->where('status', 'published')->count(),
            'draft' => BlogPost::where('author_id', $authorId)->where('status', 'draft')->count(),
            'archived' => BlogPost::where('author_id', $authorId)->where('status', 'archived')->count(),
            'views' => BlogPost::where('author_id', $authorId)->sum('views_count'),
        ];
        
    }
}