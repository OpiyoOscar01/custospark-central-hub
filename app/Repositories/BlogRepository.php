<?php

namespace App\Repositories;

use App\Models\Author;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;

class BlogRepository
{
    protected $blog;

    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }
    public function getAll()
    {
        return $this->blog->with(['category', 'author']); // Returns a query builder instance
    }
    

    public function create(array $data)
    {
        $user =Auth::user(); // Get the authenticated user
    
        // Check if an author record already exists for the authenticated user
        $author = Author::firstOrCreate(
            ['id' => $user->id],                 // Match by user ID
            ['name' => $user->name]              // Create if not found
        );
    
        // Now create the blog post
        $blog=$this->blog->create([
            'title' => $data['title'],
            'content' => $data['content'],
            'category_id' => $data['category_id'] ?? null,
            'author_id' => $author->id,
            'featured' => $data['featured'] ?? false,
        ]);

        return $blog;}
    

    public function findById($id)
    {
        return $this->blog->with(['category', 'author'])->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $blog = $this->blog->findOrFail($id);
        $blog->update($data);
        return $blog;
    }

    public function delete($id)
    {
        $blog = $this->blog->findOrFail($id);
        $blog->delete();
        return true;
    }
}
