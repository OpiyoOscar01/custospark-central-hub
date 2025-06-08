<?php

namespace App\Repositories;

use App\Models\JobApplication;
use App\Services\NotificationService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
class JobApplicationRepository
{
    public function getAllApplications(int $perPage = 10): LengthAwarePaginator
    {
        return JobApplication::with(['job', 'applicant', 'reviewer'])
            ->latest()
            ->paginate($perPage);
    }

    public function createApplication(array $data): JobApplication
    {
        // dd($data);
        //   if($data['phone']){
        //     Auth::user()->update(['phone' => $data['phone']]);
        // }
        $application= JobApplication::create($data);
        
        // Send notification
        // Mail::to($application->applicant->email)
        //     ->send(new ApplicationReceived($application));
            $notification=new NotificationService();
            $notification->sendNotification('Application Submission',"Your Application has been submitted successfully",'user','in_app',Auth::id(),);
            return $application;
    }

    public function updateApplication(JobApplication $application, array $data): JobApplication
    {
        $application->update($data);
        return $application;
    }

    public function updateApplicationStatus(JobApplication $application, array $data): JobApplication
    {
        $previousStatus = $application->status;
        
        $application->update([
            'status' => $data['status'],
            'internal_notes' => $data['internal_notes'] ?? null,
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id()
        ]);

        return $application;
    }

    public function getApplicationStats(): array
    {
        return [
            'total' => JobApplication::count(),
            'pending' => JobApplication::where('status', 'pending')->count(),
            'shortlisted' => JobApplication::where('status', 'shortlisted')->count(),
            'interviewing' => JobApplication::whereIn('status', ['interview_scheduled', 'interviewed'])->count(),
            'hired' => JobApplication::where('status', 'hired')->count(),
        ];
    }
}