<?php

namespace App\Mail;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $previousStatus;

    public function __construct(JobApplication $application, string $previousStatus)
    {
        $this->application = $application;
        $this->previousStatus = $previousStatus;
    }

    public function build()
    {
        return $this->markdown('emails.applications.status-updated')
                    ->subject('Application Status Updated - ' . $this->application->job->title);
    }
}