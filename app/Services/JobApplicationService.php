<?php
namespace App\Services;

use App\Mail\ApplicationReceived;
use App\Mail\ApplicationStatusUpdated;
use App\Models\CompanyJob;
use App\Models\JobApplication;
use App\Repositories\JobApplicationRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class JobApplicationService
{
    protected $applicationRepository;
    protected $emailService;

    public function __construct(
        JobApplicationRepository $applicationRepository,
        EmailService $emailService
    ) {
        $this->applicationRepository = $applicationRepository;
        $this->emailService          = $emailService;
    }

    public function getAllApplications(): LengthAwarePaginator
    {
        return $this->applicationRepository->getAllApplications();
    }

    public function createApplication(CompanyJob $job, array $data): JobApplication
    {
        $data['user_id'] = Auth::id();
        $data['company_job_id']  = $job->id;
        $data['status']  = 'pending';
      


        if (isset($data['resume'])) {
            $data['resume_path'] = $this->handleResume($data['resume']);
        }

        if (isset($data['cover_letter'])) {
            $data['cover_letter_path'] = $this->handleCoverLetter($data['cover_letter']);
        }

        $application = $this->applicationRepository->createApplication($data);
        return $application;
    }

    public function updateApplicationStatus(JobApplication $application, array $data): JobApplication
    {
        $previousStatus = $application->status;

        $application = $this->applicationRepository->updateApplicationStatus($application, $data);

        // Send status update notification
        Mail::to($application->applicant->email)
            ->send(new ApplicationStatusUpdated($application, $previousStatus));

        // Handle interview scheduling if status is updated to interview_scheduled
        if ($data['status'] === 'interview_scheduled') {
            $this->emailService->sendInterviewInvitation($application->interview);
        }

        // Handle job offer if status is updated to offered
        if ($data['status'] === 'offered') {
            $this->emailService->sendOfferLetter($application->offer);
        }

        return $application;
    }

    public function downloadResume(JobApplication $application): BinaryFileResponse
    {
        return response()->file(Storage::path($application->resume_path));
    }

    public function downloadCoverLetter(JobApplication $application): BinaryFileResponse
    {
        return response()->file(Storage::path($application->cover_letter_path));
    }

    public function getApplicationStats(): array
    {
        return $this->applicationRepository->getApplicationStats();
    }

    protected function handleResume($file): string
    {
        return $file->store('applications/resumes', 'public');
    }

    protected function handleCoverLetter($file): string
    {
        return $file->store('applications/cover-letters', 'public');
    }
}
