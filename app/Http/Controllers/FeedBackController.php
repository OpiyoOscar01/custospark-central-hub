<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Models\App;
use App\Models\Feedback;
use App\Services\FeedbackService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class FeedbackController extends Controller
{
    protected FeedbackService $service;

    public function __construct(FeedbackService $service)
    {
        $this->service = $service;
    }

   public function create()
{
    $source = request()->get('source', 'dashboard');
    $app = App::where('slug', 'custospark')->firstOrFail();
    $userId = Auth::id();
   

    return view('feedback.create', compact('app', 'source', 'userId'));
}


public function store(StoreFeedbackRequest $request)
{
    $this->service->submitFeedback([
        'user_id' => $request->input('user_id'),
        'app_id' => $request->input('app_id'),
        'type' => $request->input('type'),
        'message' => $request->input('message'),
        'complaint_categories' => $request->input('complaint_categories', []),
        'attachments' => $request->file('attachments', []),
        'source' => $request->input('source'),
    ]);

    // Validate and sanitize the source URL
    $source = $request->input('source');
    $fallback = route('dashboard');

    if (! $source || ! str_starts_with($source, url('/'))) {
        $source = $fallback;
    }

    return redirect()->to($source)->with('success', 'Thank you for your feedback!');
}



    // public function index()
    // {
    //     $feedback = $this->service->listAll();
    //     return view('feedback.index', compact('feedback')); // Optional admin view
    // }
  

public function index(Request $request)
{
    $query = Feedback::with('user');

    if ($search = $request->input('search')) {
        $query->whereHas('user', function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    if ($rating = $request->input('rating')) {
        $query->where('rating', $rating);
    }

    if ($status = $request->input('status')) {
        $query->where('status', $status);
    }

    $feedback = $query->latest()->paginate(10);

    return view('feedback.index', compact('feedback'));
}
public function show(Feedback $feedback)
    {
        // Load relationships if needed
        $feedback->load('user', 'app');

        return view('feedback.show', compact('feedback'));
    }

    // Update feedback status
    public function edit(Feedback $feedback)
    {
        $feedback->load('user', 'app');

        return view('feedback.edit', compact('feedback'));
    }


public function update(Request $request, Feedback $feedback)
{
    $request->validate([
        'status' => 'required|in:pending,triaged,in_progress,resolved,responded,closed,rejected',
        'admin_response' => 'nullable|string',
    ]);

    $feedback->update([
        'status' => $request->status,
        'admin_response' => $request->admin_response,
        'responded_at' => now(),
        'admin_id' => Auth::id(),
    ]);

    return redirect()->route('feedback.index')->with('success', 'Feedback updated successfully.');
}
public function destroy(Feedback $feedback)
{
    $feedback->delete();

    return back()->with('success', 'Feedback deleted successfully.');
}


public function downloadAttachment($filename)
{
    $path = 'feedback_attachments/' . $filename;

    if (!Storage::exists($path)) {
        abort(404, 'File not found.');
    }

    return Storage::download($path);
}

public function viewAttachment($filename)
{
    $path = 'feedback_attachments/' . $filename;

    if (!Storage::exists($path)) {
        abort(404, 'File not found.');
    }

    $mime = Storage::mimeType($path);
    return Response::make(Storage::get($path), 200, [
        'Content-Type' => $mime,
        'Content-Disposition' => 'inline;
        filename="' . $filename . '"',
    ]);
}

}

