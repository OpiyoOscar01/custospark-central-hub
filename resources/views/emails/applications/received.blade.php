@component('mail::message')
# Application Received

Dear {{ $application->applicant->name }},

Thank you for applying for the position of **{{ $application->job->title }}** at our company. We have received your application and will review it carefully.

## Application Details:
- **Position:** {{ $application->job->title }}
- **Department:** {{ $application->job->department }}
- **Application Date:** {{ $application->created_at->format('F j, Y') }}

We will contact you regarding the next steps in the recruitment process. In the meantime, you can track your application status through our portal.

@component('mail::button', ['url' => route('applications.show', $application)])
View Application Status
@endcomponent

Best regards,  
{{ config('app.name') }} Team
@endcomponent