<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\SentEmail;
use App\Models\JobInterview;
use App\Models\JobOffer;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function sendInterviewInvitation(JobInterview $interview): void
    {
        $template = EmailTemplate::where('type', 'interview_scheduled')
            ->where('is_active', true)
            ->first();

        if (!$template) {
            return;
        }

        $data = [
            'candidate_name' => $interview->application->applicant->name,
            'interviewer_name' => $interview->interviewer->name,
            'date' => $interview->scheduled_at->format('l, F j, Y'),
            'time' => $interview->scheduled_at->format('g:i A'),
            'type' => $interview->type,
            'location' => $interview->location
        ];

        $content = $template->renderContent($data);

        Mail::to($interview->application->applicant->email)
            ->send(new \App\Mail\InterviewInvitation($interview, $content));

        $this->logEmail($template, $interview, 'interview');
    }

    public function sendOfferLetter(JobOffer $offer): void
    {
        $template = EmailTemplate::where('type', 'offer_letter')
            ->where('is_active', true)
            ->first();

        if (!$template) {
            return;
        }

        $data = [
            'candidate_name' => $offer->application->applicant->name,
            'position' => $offer->application->job->title,
            'salary' => "{$offer->salary_currency} {$offer->salary_offered}",
            'start_date' => $offer->start_date->format('l, F j, Y'),
            'benefits' => $offer->additional_benefits
        ];

        $content = $template->renderContent($data);

        Mail::to($offer->application->applicant->email)
            ->send(new \App\Mail\OfferLetter($offer, $content));

        $this->logEmail($template, $offer, 'offer');
    }

    protected function logEmail(EmailTemplate $template, $model, string $type): void
    {
        SentEmail::create([
            'template_id' => $template->id,
            'emailable_type' => get_class($model),
            'emailable_id' => $model->id,
            'recipient_email' => $model->application->applicant->email,
            'subject' => $template->subject,
            'content' => $template->content,
            'sent_at' => now(),
            'status' => 'sent'
        ]);
    }
}