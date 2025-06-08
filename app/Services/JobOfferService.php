<?php

namespace App\Services;

use App\Models\JobOffer;
use App\Models\JobApplication;
use App\Events\OfferCreated;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JobOfferService
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function createOffer(JobApplication $application, array $data): JobOffer
    {
        $offer = JobOffer::create([
            'application_id' => $application->id,
            'salary_offered' => $data['salary_offered'],
            'salary_currency' => $data['salary_currency'],
            'start_date' => Carbon::parse($data['start_date']),
            'additional_benefits' => $data['additional_benefits'] ?? null,
            'special_terms' => $data['special_terms'] ?? null,
            'status' => 'draft',
            'created_by' => Auth::id()
        ]);

        event(new OfferCreated($offer));

        return $offer;
    }

    public function sendOffer(JobOffer $offer): JobOffer
    {
        $offer->update([
            'status' => 'sent',
            'sent_at' => now()
        ]);

        $this->emailService->sendOfferLetter($offer);

        return $offer;
    }

    public function handleResponse(JobOffer $offer, string $response, ?string $feedback = null): JobOffer
    {
        $offer->update([
            'status' => $response,
            'response_at' => now(),
            'candidate_feedback' => $feedback
        ]);

        if ($response === 'accepted') {
            $this->handleAcceptedOffer($offer);
        }

        return $offer;
    }

    protected function handleAcceptedOffer(JobOffer $offer): void
    {
        // Update application status
        $offer->application->update(['status' => 'hired']);

        // Close the job posting if all positions are filled
        $job = $offer->application->job;
        $hiredCount = $job->applications()->where('status', 'hired')->count();
        
        if ($hiredCount >= $job->positions_available) {
            $job->update(['status' => 'closed']);
        }

        // Send welcome email
        $this->emailService->sendWelcomeEmail($offer);
    }
}