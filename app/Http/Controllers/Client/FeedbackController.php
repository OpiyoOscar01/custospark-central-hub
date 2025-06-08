<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientFeedbackRequest; // Ensure this class exists in the specified namespace
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\ClientFeedback;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

    class FeedbackController extends Controller
    {
    use AuthorizesRequests;
    public function index(): View
    {
        $feedbacks = Auth::user()->client->feedbacks()
            ->with(['project'])
            ->latest()
            ->get();

        return view('client.feedbacks.index', compact('feedbacks'));
    }

    public function create(): View
    {
        $projects = Auth::user()->client->projects;
        return view('client.feedbacks.create', compact('projects'));
    }

    public function store(ClientFeedbackRequest $request): RedirectResponse
    {
        $feedback = ClientFeedback::create([
            'project_id' => $request->project_id,
            'client_id' => Auth::user()->client->id,
            'content' => $request->content,
            'type' => $request->type,
            'status' => 'pending'
        ]);

        return redirect()->route('client.feedbacks.index')
            ->with('success', 'Feedback submitted successfully.');
    }

    public function show(ClientFeedback $feedback): View
    {
        $this->authorize('view', $feedback);
        return view('client.feedbacks.show', compact('feedback'));
    }
}