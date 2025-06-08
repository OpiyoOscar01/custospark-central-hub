<?php

namespace App\Services;

use App\Models\JobInterview;
use App\Models\JobApplication;
use App\Events\InterviewScheduled;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class InterviewService
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function scheduleInterview(JobApplication $application, array $data): JobInterview
    {
        $interview = JobInterview::create([
            'application_id' => $application->id,
            'interviewer_id' => $data['interviewer_id'],
            'scheduled_at' => Carbon::parse($data['scheduled_at']),
            'type' => $data['type'],
            'location' => $data['location'] ?? null,
            'status' => 'scheduled'
        ]);

        // Send notifications
        event(new InterviewScheduled($interview));
        $this->emailService->sendInterviewInvitation($interview);

        return $interview;
    }

    public function recordFeedback(JobInterview $interview, array $data): JobInterview
    {
        $interview->update([
            'feedback' => $data['feedback'],
            'rating' => $data['rating'],
            'status' => 'completed'
        ]);

        // Record question responses
        foreach ($data['responses'] as $response) {
            $interview->responses()->create($response);
        }

        return $interview;
    }

    public function rescheduleInterview(JobInterview $interview, array $data): JobInterview
    {
        $interview->update([
            'scheduled_at' => Carbon::parse($data['scheduled_at']),
            'status' => 'rescheduled'
        ]);

        $this->emailService->sendInterviewRescheduled($interview);

        return $interview;
    }

    public function cancelInterview(JobInterview $interview, string $reason = null): JobInterview
    {
        $interview->update([
            'status' => 'cancelled',
            'notes' => $reason
        ]);

        $this->emailService->sendInterviewCancellation($interview);

        return $interview;
    }
}