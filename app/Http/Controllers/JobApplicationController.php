<?php
namespace App\Http\Controllers;

use App\Http\Requests\JobApplicationRequest;
use App\Http\Requests\UpdateJobApplicationRequest;
use App\Mail\StandardEmail;
use App\Models\CompanyJob;
use App\Models\JobApplication;
use App\Repositories\JobApplicationRepository;
use App\Services\JobApplicationService;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class JobApplicationController extends Controller
{
    protected $applicationService;
    protected $jobRepository;
    protected $notificationService;

    public function __construct(JobApplicationService $applicationService, JobApplicationRepository $jobRepository, NotificationService $notificationService)

    {
        $this->applicationService = $applicationService;
        $this->jobRepository = $jobRepository;
        $this->notificationService = $notificationService;
    }

    public function index(): View
    {
        $applications = $this->applicationService->getAllApplications();
        $stats        = $this->applicationService->getApplicationStats();
        $jobs=CompanyJob::all();

        return view('applications.index', compact('applications', 'stats','jobs'));
    }

    
    public function applicationProceed(Request $request)
{
    $jobId = $request->query('job_id');

    // Store in session
    session(['job_id' => $jobId]);
    $jobId=Session::get('job_id');

    return view('pages.application_proceed');
}


    public function myApplications():View{
        $user = Auth::user();
        $applications = JobApplication::where('user_id', $user->id)
            ->with(['job'])
            ->latest()
            ->paginate(10);
        return view('applications.my_applications', compact('applications'));
    }

    public function userSpecificApplication(int $application): View
    {
        $application = JobApplication::with('job')->findOrFail($application);
        $job = CompanyJob::findOrFail($application->company_job_id);

        return view('applications.user_specific_show', compact('application', 'job'));
    }

   

    public function create(CompanyJob $job): View
    {
        return view('applications.create', compact('job'));
    }



public function store(JobApplicationRequest $request, CompanyJob $job): RedirectResponse
{
    // Create the application and get the result
    $application = $this->applicationService->createApplication($job, $request->validated());

    // Get the current authenticated user
    $user = Auth::user();

    // Build the message
    $message = [
        'title' => 'Application Received',
        'body' => "Dear {$user->first_name},\n\n"
                . "We’ve successfully received your application for the {$job->title} role.\n\n"
                . "Our team will begin the initial screening shortly. You’ll be notified of any updates.\n\n"
                . "Thank you for your interest in joining us!",
        'tip' => "💡 Tip: Ensure your profile and documents are up to date while you wait.",
    ];

    // Generate view details URL
    $viewDetailsUrl = route('user.application.specific.show', ['application' => $application]);

    // Send email with CTA button
    Mail::to($user->email)->send(new StandardEmail(
        $message['title'],
        $message['body'],
        $viewDetailsUrl,       // ctaUrl
        'View Details',        // ctaLabel
        $message['tip']
    ));

    return redirect()->route('user.applications.all')
        ->with('success', 'Application submitted successfully.');
}



    public function show(int $application): View
    {
          $application = JobApplication::find($application);
        //   $application=$application->with('job');
         $job=CompanyJob::find($application->company_job_id);

        return view('applications.show', compact('application','job'));
    }
    public function destroy(JobApplication $application): RedirectResponse
{
    dd("Here");
    $application->delete();

    return redirect()->back()->with('success', 'Application deleted successfully.');
}
public function showEditUserApplicationForm(JobApplication $application): View{
    $job = CompanyJob::findOrFail($application->company_job_id);
    return view('applications.user_specific_edit', compact('application', 'job'));
}
public function updateUserApplication(UpdateJobApplicationRequest $request, JobApplication $application): RedirectResponse
{
    $validated = $request->validated();

    // If the user is updating their own application, ensure they can only update allowed fields
    if (Auth::id() !== $application->user_id) {
        return redirect()->back()->withErrors(['error' => 'You are not authorized to update this application.']);
    }

    try {
        // Handle resume file upload
        if ($request->hasFile('resume')) {
            // Delete old resume if it exists
            if ($application->resume_path && Storage::disk('public')->exists($application->resume_path)) {
                Storage::disk('public')->delete($application->resume_path);
            }

            // Store new resume
            $resumePath = $request->file('resume')->store('applications/resumes', 'public');
            $validated['resume_path'] = $resumePath;
        }

        // Handle cover letter file upload
        if ($request->hasFile('cover_letter')) {
            // Delete old cover letter if it exists
            if ($application->cover_letter_path && Storage::disk('public')->exists($application->cover_letter_path)) {
                Storage::disk('public')->delete($application->cover_letter_path);
            }

            // Store new cover letter
            $coverLetterPath = $request->file('cover_letter')->store('applications/cover_letters', 'public');
            $validated['cover_letter_path'] = $coverLetterPath;
        }

        // Remove file inputs from validated data if they weren't uploaded
        // to prevent overwriting existing file paths with null
        if (!$request->hasFile('resume')) {
            unset($validated['resume']);
        }
        if (!$request->hasFile('cover_letter')) {
            unset($validated['cover_letter']);
        }

        // Update the application with validated data
        $application->update($validated);

        return redirect()->route('user.applications.all', $application)
            ->with('success', 'Application updated successfully.');

    } catch (\Exception $e) {
        // Log the error for debugging
        Log::error('Application update failed: ' . $e->getMessage());
        
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => 'Failed to update application. Please try again.']);
    }
}

    
    public function withdraw(JobApplication $application): RedirectResponse
{
    $application->delete();

    return redirect()->back()->with('success', 'Application withdrawn successfully.');
}


public function updateStatus(Request $request, JobApplication $application): RedirectResponse
{
    $validated = $request->validate([
        'status'         => 'required|in:pending,reviewing,shortlisted,interview_scheduled,interviewed,offered,hired,rejected',
        'internal_notes' => 'nullable|string',
    ]);

    // $this->applicationService->updateApplicationStatus($application, $validated);
    $this->jobRepository->updateApplicationStatus($application, [
        'status' => $validated['status'],
        'internal_notes' => $validated['internal_notes'] ?? null,
        'reviewed_at' => now(),
        'reviewed_by' => Auth::id()
    ]);

    $user = $application->applicant;

 $statusMessages = [
    'pending' => [
        'title' => 'Application Received',
        'body' => "Dear {$user->first_name},\n\nWe’ve successfully received your application for the position of {$application->job->title} in the {$application->job->department} department.\n\n"
            . "Location: {$application->job->location}" 
            . ($application->job->is_remote ? " (Remote option available)" : "") . "\n"
            . "Type: {$application->job->type}\n"
            . "Experience Level: {$application->job->experience_level}\n"
            . "Salary Range: "
            . ($application->job->salary_min && $application->job->salary_max 
                ? "{$application->job->salary_currency} {$application->job->salary_min} - {$application->job->salary_max}" 
                : "Not disclosed") . "\n\n"
            . "Application Deadline: " . ($application->job->deadline ? $application->job->deadline->format('M d, Y') : 'Open until filled') . "\n\n"
            . "Our team will begin the initial screening soon. Thank you for your interest!",
        'tip' => "💡 Tip: Double-check your profile and uploaded documents to ensure everything is up-to-date while you wait.",
    ],

    'reviewing' => [
        'title' => 'Application Under Review',
        'body' => "Dear {$user->first_name},\n\nYour application for {$application->job->title} in the {$application->job->department} department is now under review.\n\n"
            . "Please be patient as we carefully assess all candidates. You will be notified about the next steps soon.",
        'tip' => "💡 Tip: Research the company, role, and recent projects to prepare in case you're shortlisted.",
    ],

    'shortlisted' => [
        'title' => 'You Have Been Shortlisted!',
        'body' => "Dear {$user->first_name},\n\nCongratulations! You have been shortlisted for the {$application->job->title} position in the {$application->job->department} department.\n\n"
            . "We look forward to learning more about you. Stay tuned for interview scheduling details.",
        'tip' => "💡 Tip: Prepare to discuss your relevant experience and achievements.",
    ],

    'interview_scheduled' => [
        'title' => 'Interview Scheduled',
        'body' => "Dear {$user->first_name},\n\nYour interview for the {$application->job->title} position has been scheduled.\n\n"
            . "Please check your dashboard for date, time, and format details. Good luck!",
        'tip' => "💡 Tip: Test your equipment beforehand if it's virtual, and review common questions for this role.",
    ],

   'interviewed' => [
    'title' => 'Thank You for Meeting With Us',
    'body'  => "Dear {$user->first_name},\n\n"
             . "Thank you for taking the time to meet with our team about the {$application->job->title} position. "
             . "We enjoyed learning more about your background and how your skills could contribute to our goals.\n\n"
             . "Over the next few days we’ll be reviewing all interviews and comparing feedback. "
             . "You can expect an update—whether it’s a next-round invitation or our final decision—within one week.\n\n"
             . "In the meantime, please don’t hesitate to reach out if any additional questions arise. "
             . "We appreciate your interest and the effort you invested in the interview process.",
    'tip'   => "💡 Tip: Jot down the key questions you were asked and your responses. "
             . "This reflection will help you strengthen future interviews or follow-up discussions."
],


    'offered' => [
        'title' => 'We Are Excited to Make You an Offer',
        'body' => "Dear {$user->first_name},\n\nWe’re excited to offer you the position of {$application->job->title}.\n\n"
            . "Please review the offer on your dashboard and respond at your convenience.",
        'tip' => "💡 Tip: Review the offer carefully and ask any questions you have about the role or benefits.",
    ],

    'hired' => [
        'title' => 'Welcome to the Team!',
        'body' => "Dear {$user->first_name},\n\nWelcome aboard as our new {$application->job->title}!\n\n"
            . "Your onboarding process will begin soon.",
        'tip' => "💡 Tip: Familiarize yourself with our company culture and tools to start strong.",
    ],

   'rejected' => [
    'title' => 'Application Outcome for the ' . $application->job->title,
    'body'  => "Dear {$user->first_name},\n\n"
             . "Thank you sincerely for applying for the {$application->job->title} position at our company. "
             . "We truly appreciate the time, effort, and interest you’ve shown.\n\n"
             . "After a thorough review of your application and consideration alongside many strong candidates, "
             . "we have decided to move forward with others for this particular role. "
             . "This decision does not reflect negatively on your abilities—it was a difficult choice.\n\n"
             . "We encourage you to keep an eye on future openings, as we would be happy to consider you again.",
    'tip'   => "💡 Tip: Take this as a stepping stone—every application is progress. "
             . "You can request feedback or explore similar roles that better match your experience."
],

];


    $status = $validated['status'];
    $message = $statusMessages[$status];
    // Generate the URL for viewing the application details
    $viewDetailsUrl = route('user.application.specific.show', ['application' => $application]);

    // Send email with a "View Details" button/link
    Mail::to($user->email)->send(new StandardEmail(
        $message['title'],
        $message['body'],
         $viewDetailsUrl,        // ctaUrl: link to view application details
        'View Details',         // ctaLabel
        $message['tip'] ?? 'You can login to your dashboard for more details.'
    ));
    $this->notificationService->
        sendNotification(
        $message['title'],
        $message['body'],
        'user',
        'in_app',
        $application->applicant->id,
    );

    return back()->with('success', 'Application status updated and email sent successfully.');
}



    public function downloadResume(JobApplication $application)
    {
        return $this->applicationService->downloadResume($application);
    }

    public function downloadCoverLetter(JobApplication $application)
    {
        return $this->applicationService->downloadCoverLetter($application);
    }
}
