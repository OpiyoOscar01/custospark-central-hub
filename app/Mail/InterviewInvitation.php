<?php

namespace App\Mail;

use App\Models\JobInterview;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterviewInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $interview;
    public $content;

    public function __construct(JobInterview $interview, string $content)
    {
        $this->interview = $interview;
        $this->content = $content;
    }

    public function build()
    {
        return $this->markdown('emails.applications.interview-invitation')
                    ->subject('Interview Invitation - ' . $this->interview->application->job->title);
    }
}