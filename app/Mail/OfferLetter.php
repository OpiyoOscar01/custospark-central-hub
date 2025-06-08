<?php
namespace App\Mail;

use App\Models\JobOffer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OfferLetter extends Mailable
{
    use Queueable, SerializesModels;

    public $offer;
    public $content;

    public function __construct(JobOffer $offer, string $content)
    {
        $this->offer   = $offer;
        $this->content = $content;
    }

    public function build()
    {
        return $this->markdown('emails.applications.offer-letter')
            ->subject('CompanyJob Offer - ' . $this->offer->application->job->title);
    }
}
