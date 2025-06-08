<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Repositories\BlogPostRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogPostService
{
    protected $blogPostRepository;

    public function __construct(BlogPostRepository $blogPostRepository)
    {
        $this->blogPostRepository = $blogPostRepository;
    }

    public function createPost(array $data): BlogPost
    {
        $data['slug'] = Str::slug($data['title']);
        $data['author_id'] = Auth::id();
        
        if (isset($data['featured_image'])) {
            $data['featured_image'] = $this->handleFeaturedImage($data['featured_image']);
        }

        if ($data['status'] === 'published' && !isset($data['published_at'])) {
            $data['published_at'] = now();
        }

        return BlogPost::create($data);
    }

    public function updatePost(BlogPost $post, array $data): BlogPost
    {
        if (isset($data['title']) && $post->title !== $data['title']) {
            $data['slug'] = Str::slug($data['title']);
        }

        if (isset($data['featured_image'])) {
            $this->deleteFeaturedImage($post);
            $data['featured_image'] = $this->handleFeaturedImage($data['featured_image']);
        }

        if (isset($data['status']) && $data['status'] === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);
        return $post;
    }

    public function deletePost(BlogPost $post): bool
    {
        $this->deleteFeaturedImage($post);
        return $post->delete();
    }

    public function publishPost(BlogPost $post): BlogPost
    {
        $post->update([
            'status' => 'published',
            'published_at' => now()
        ]);

        return $post;
    }

    public function unpublishPost(BlogPost $post): BlogPost
    {
        $post->update([
            'status' => 'draft',
            'published_at' => null
        ]);

        return $post;
    }

    public function archivePost(BlogPost $post): BlogPost
    {
        $post->update([
            'status' => 'archived'
        ]);

        return $post->refresh();
    }

    public function incrementViews(BlogPost $post): void
    {
        $post->increment('views_count');
    }

   
    protected function handleFeaturedImage($image): string
    {
        $path = $image->store('blog/featured-images', 'public');
        return Storage::url($path);
    }

    protected function deleteFeaturedImage(BlogPost $post): void
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $post->featured_image));
        }
    }
}