@component('mail::message')
# CompanyJob Offer Letter

Dear {{ $offer->application->applicant->name }},

{!! $content !!}

## Offer Details:
- **Position:** {{ $offer->application->job->title }}
- **Department:** {{ $offer->application->job->department }}
- **Start Date:** {{ $offer->start_date->format('F j, Y') }}
- **Salary:** {{ $offer->salary_currency }} {{ number_format($offer->salary_offered, 2) }}

@if($offer->additional_benefits)
### Additional Benefits:
{!! $offer->additional_benefits !!}
@endif

@if($offer->special_terms)
### Special Terms:
{!! $offer->special_terms !!}
@endif

Please review the offer details and respond through our portal. If you have any questions, please don't hesitate to contact us.

@component('mail::button', ['url' => route('applications.show', $offer->application)])
View Offer Details
@endcomponent

Best regards,  
{{ config('app.name') }} Team
@endcomponent