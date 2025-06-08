<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class BlogCommentController extends Controller
{
    use AuthorizesRequests;
    public function store(Request $request, BlogPost $post): RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'required|string'
        ]);

        $post->comments()->create([
            'content' => $validated['content'],
            'user_id' => Auth::id()
        ]);

        return back()->with('success', 'Comment added successfully.');
    }

    public function update(Request $request, BlogComment $comment): RedirectResponse
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string'
        ]);

        $comment->update($validated);

        return back()->with('success', 'Comment updated successfully.');
    }

    public function destroy(BlogComment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}