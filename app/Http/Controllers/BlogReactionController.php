<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogReaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class BlogReactionController extends Controller
{
    public function react(Request $request, BlogPost $post)
    {
        $validated = $request->validate([
            'type' => 'required|in:like,dislike'
        ]);

        $reaction = BlogReaction::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'post_id' => $post->id
            ],
            ['type' => $validated['type']]
        );

        $counts = [
            'likes' => $post->reactions()->where('type', 'like')->count(),
            'dislikes' => $post->reactions()->where('type', 'dislike')->count()
        ];

        return redirect()->back()->with([
            'success' => true,
            'message' => 'Reaction updated successfully.',
            'counts' => $counts
        ]);
    }

    public function unreact(BlogPost $post)
    {
        $deleted = BlogReaction::where([
            'user_id' => Auth::id(),
            'post_id' => $post->id
        ])->delete();

        $counts = [
            'likes' => $post->reactions()->where('type', 'like')->count(),
            'dislikes' => $post->reactions()->where('type', 'dislike')->count()
        ];

        return redirect()->back()->with([
            'success' => $deleted,
            'message' => $deleted ? 'Reaction removed successfully.' : 'No reaction found to remove.',
            'counts' => $counts
        ]);
    }
}