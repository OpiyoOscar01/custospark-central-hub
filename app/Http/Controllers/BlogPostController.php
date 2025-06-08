<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Services\BlogPostService;
use App\Repositories\BlogPostRepository;
use App\Http\Requests\BlogPostRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BlogPostController extends Controller
{
    use AuthorizesRequests;
    protected $blogPostService;
    protected $blogPostRepository;

    public function __construct(BlogPostService $blogPostService, BlogPostRepository $blogPostRepository)
    {
        $this->blogPostService = $blogPostService;
        $this->blogPostRepository = $blogPostRepository;
    }

    public function index(): View
    {
        $posts = $this->blogPostRepository->getAllPosts();
        $categories = BlogCategory::all();
        $stats = $this->blogPostRepository->getPostStats();
        
        // dd($posts, $categories, $stats);

        return view('blog.index', compact('posts', 'categories', 'stats'));
    }

    public function publicIndex(Request $request): View
    {
        $posts = $this->blogPostRepository->getAllPublishedPosts();
        $categories = BlogCategory::all();
        $popularPosts = $this->blogPostRepository->getPopularPosts();

        return view('blog.public.index', compact('posts', 'categories', 'popularPosts'));
    }
    public function guestUserBlogs(Request $request): View
    {
        $posts = $this->blogPostRepository->getPublishedPostsForGuests();
        $categories = BlogCategory::all();
        $popularPosts = $this->blogPostRepository->getPopularPosts();

        return view('pages.blogs', compact('posts', 'categories', 'popularPosts'));
    }

    public function create(): View
    {
        $categories = BlogCategory::all();
        return view('blog.create', compact('categories'));
    }

    public function store(BlogPostRequest $request): RedirectResponse
    {
        $this->blogPostService->createPost($request->validated());

        return redirect()->route('blog.index')
            ->with('success', 'Post created successfully.');
    }

    public function show(BlogPost $post): View
    {
        $this->blogPostService->incrementViews($post);
        $relatedPosts = $this->blogPostRepository->getRelatedPosts($post);

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    public function edit(BlogPost $post): View
    {
        $this->authorize('update', $post);
        $categories = BlogCategory::all();
        return view('blog.edit', compact('post', 'categories'));
    }

    public function update(BlogPostRequest $request, BlogPost $post): RedirectResponse
    {
        $this->authorize('update', $post);
        $this->blogPostService->updatePost($post, $request->validated());

        return redirect()->route('blog.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(BlogPost $post): RedirectResponse
    {
        $this->authorize('delete', $post);
        $this->blogPostService->deletePost($post);

        return redirect()->route('blog.index')
            ->with('success', 'Post deleted successfully.');
    }

    public function publish(BlogPost $post): RedirectResponse
    {
        $this->authorize('publish', $post);
        $this->blogPostService->publishPost($post);

        return back()->with('success', 'Post published successfully.');
    }

    public function unpublish(BlogPost $post): RedirectResponse
    {
        $this->authorize('publish', $post);
        $this->blogPostService->unpublishPost($post);

        return back()->with('success', 'Post unpublished successfully.');
    }

    public function archive(BlogPost $post): RedirectResponse
    {
        $this->authorize('update', $post);
        $this->blogPostService->archivePost($post);

        return back()->with('success', 'Post archived successfully.');
    }
}