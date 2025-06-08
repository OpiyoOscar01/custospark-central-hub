<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Services\BlogService;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    protected $blogService;
    protected $categoryService;

    public function __construct(BlogService $blogService,CategoryService $categoryService)
    {
        $this->blogService = $blogService;
        $this->categoryService = $categoryService;
    }

    public function index()
{
    // Get the blogs ordered by the latest post first, and paginate the results (e.g., 10 blogs per page)
    $blogs = $this->blogService->getAllBlogs()->orderBy('created_at', 'desc')->paginate(1); // This will fetch the latest blogs and paginate them
    
    $totalBlogs = $blogs->total(); // This will count the total number of blogs in the database
    
    $categories = $this->categoryService->getAllCategories();
    $user = Auth::user();
    
    return view('Portal.content.blog', compact(['blogs', 'categories', 'user', 'totalBlogs']));
}

    
public function markAsRead($id)
{
    $blog = Blog::findOrFail($id);

    // Mark the blog as read and set the read_at timestamp
    $blog->read = true;
    $blog->read_at = now(); // current timestamp
    $blog->save();

    return response()->json(['message' => 'Marked as read']);
}

    public function store(BlogRequest $request)
    {
        $this->blogService->createBlog($request->validated()); 
        // returns Blog object
        return redirect(route('portal.blog'))->with('success', 'Blog created successfully.');
    }

    public function show($id)
    {
        return $this->blogService->getBlogById($id); // returns single Blog object
    }

    public function update(BlogRequest $request, $id)
    {
         $this->blogService->updateBlog($id, $request->validated()); 
        return redirect(route(name: 'portal.blog'))->with('success', 'Blog post updated successfully.');

    }

    public function destroy($id)
    {
        $this->blogService->deleteBlog($id);  
        
        return redirect(route(name: 'portal.blog'))->with('success', 'Blog post updated successfully.');

    }

    public function updateBlog(Request $request, Blog $blog)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'category_id' => 'nullable|exists:categories,id',
    ]);

    $blog->update(array_merge($validated, [
        'author_id' => Auth::id(),
    ]));

    return redirect(route(name: 'portal.blog'))->with('success', 'Blog post updated successfully.');
}

}
