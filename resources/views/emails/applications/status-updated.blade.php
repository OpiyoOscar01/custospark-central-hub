@component('mail::message')
# Application Status Update

Dear {{ $application->applicant->name }},

Your application status for the position of **{{ $application->job->title }}** has been updated.

## Status Update:
- **Previous Status:** {{ ucfirst(str_replace('_', ' ', $previousStatus)) }}
- **New Status:** {{ ucfirst(str_replace('_', ' ', $application->status)) }}
- **Updated On:** {{ $application->updated_at->format('F j, Y') }}

@if($application->status === 'shortlisted')
We are pleased to inform you that your application has been shortlisted. We will contact you soon regarding the next steps.
@elseif($application->status === 'rejected')
We appreciate your interest in joining our team. However, we have decided to move forward with other candidates at this time.
@endif

You can view more details about your application through our portal.

@component('mail::button', ['url' => route('applications.show', $application)])
View Application Details
@endcomponent

Best regards,  
{{ config('app.name') }} Team
@endcomponent