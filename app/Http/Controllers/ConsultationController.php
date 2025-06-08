<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Http\Requests\ConsultationRequest;
use App\Mail\StandardEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ConsultationController extends Controller
{
    // Display all consultationspublic function index(Request $request)
    public function index(Request $request)
{
    $query = Consultation::query();

    // Timezone filter
    if ($request->filled('timezone')) {
        $query->where('timezone', $request->timezone);
    }

    // Preferred Day filter (extract weekday name from preferred_date)
    if ($request->filled('preferred_day')) {
        $query->whereRaw("DAYNAME(preferred_date) = ?", [$request->preferred_day]);
    }

    // Time range filters
    if ($request->filled('preferred_start')) {
        $query->whereTime('preferred_start', '>=', $request->preferred_start);
    }

    if ($request->filled('preferred_end')) {
        $query->whereTime('preferred_end', '<=', $request->preferred_end);
    }

    // Meeting Type filter
    if ($request->filled('meeting_type')) {
        $query->where('meeting_type', $request->meeting_type);
    }

    // Status filter
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Results
    $consultations = $query->latest()->paginate(10)->withQueryString();

    // Dynamic dropdown population (optional if static options used)
    $timezones = Consultation::select('timezone')->distinct()->pluck('timezone');
    $meetingTypes = Consultation::select('meeting_type')->distinct()->pluck('meeting_type');
    $statuses = Consultation::select('status')->distinct()->pluck('status');

    return view('consultations.index', compact(
        'consultations',
        'timezones',
        'meetingTypes',
        'statuses'
    ));
}



    // Show form to create new consultation
    public function create()
    {
        return view('consultations.create');
    }

    // Store a new consultation (form submission)public function store(ConsultationRequest $request)
public function store(ConsultationRequest $request)
{
    $data = $request->validated();

    if ($request->input('country_code') === 'custom') {
        $data['country_code'] = $request->input('custom_country_code');
    }

    $consultation = Consultation::create($data);

  // ✅ Send pending confirmation email
Mail::to($consultation->email)->send(new StandardEmail(
    title: 'Consultation Request Received',
    mailBody: "Dear {$consultation->full_name},\n\n" .
              "Thank you for requesting a consultation. Our team will review your request and confirm the schedule shortly.\n\n" .
              "We appreciate your interest!",
    ctaLabel: 'View Your Request',
    tip: 'You will receive an update when the consultation is confirmed.'
));


    return redirect()->route('post-consultation')->with('success', 'Your consultation has been scheduled successfully.');
}

public function update(Request $request, Consultation $consultation)
{
    $data = $request->validate([
        'status' => 'nullable|in:pending,scheduled,completed,cancelled',
    ]);

    $originalStatus = $consultation->status;
    $consultation->update($data);

    $newStatus = $data['status'] ?? $originalStatus;

    // ✅ Send emails based on status change
    if ($newStatus !== $originalStatus) {
        $mailBody = '';
        $title = '';
        $ctaLabel = 'View Details';

     switch ($newStatus) {
    case 'scheduled':
        $title = 'Your Consultation Has Been Scheduled';
        $mailBody = "Dear {$consultation->full_name},\n\n" .
                    "Your consultation has been scheduled.\n\n" .
                    "Date: {$consultation->preferred_date}\n" .
                    "Time: {$consultation->preferred_start} - {$consultation->preferred_end} ({$consultation->timezone})\n" .
                    "Type: " . ucfirst($consultation->meeting_type) . "\n\n" .
                    "We look forward to speaking with you!\n\n" .
                    "If you have any questions or need to reschedule, please contact us at support@custospark.com.";
        break;

    case 'completed':
        $title = 'Consultation Completed';
        $mailBody = "Hi {$consultation->full_name},\n\n" .
                    "Thank you for attending the consultation. We hope it was valuable.\n\n" .
                    "If you have any feedback or further questions, feel free to reach out to us at support@custospark.com.\n\n" .
                    "We appreciate your time and interest!";
        break;

    case 'cancelled':
        $title = 'Consultation Cancelled';
        $mailBody = "Hi {$consultation->full_name},\n\n" .
                    "We regret to inform you that your consultation has been cancelled.\n\n" .
                    "If you believe this is a mistake or would like to reschedule, please contact us at support@custospark.com.";
        break;
}


        if ($title && $mailBody) {
            Mail::to($consultation->email)->send(new StandardEmail(
                title: $title,
                mailBody: $mailBody,
                ctaLabel: $ctaLabel
            ));
        }
    }

    return redirect()->route('consultations.index')->with('success', 'Consultation updated successfully.');
}


    // Show a single consultation
    public function show(Consultation $consultation)
    {
        return view('consultations.show', compact('consultation'));
    }

    // Show edit form
    public function edit(Consultation $consultation)
    {
        // Convert comma-separated days to array for editing
        $consultation->preferred_days = explode(',', $consultation->preferred_days ?? '');
        return view('consultations.edit', compact('consultation'));
    }

    // Update the consultation



    // Delete a consultation
    public function destroy(Consultation $consultation)
    {
        $consultation->delete();
        return redirect()->route('consultations.index')->with('success', 'Consultation deleted.');
    }
}
