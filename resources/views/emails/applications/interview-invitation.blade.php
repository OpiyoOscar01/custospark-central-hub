@component('mail::message')
# Interview Invitation

Dear {{ $interview->application->applicant->name }},

{!! $content !!}

## Interview Details:
- **Position:** {{ $interview->application->job->title }}
- **Date:** {{ $interview->scheduled_at->format('l, F j, Y') }}
- **Time:** {{ $interview->scheduled_at->format('g:i A') }}
- **Type:** {{ ucfirst($interview->type) }}
@if($interview->type !== 'video')
- **Location:** {{ $interview->location }}
@else
- **Meeting Link:** {{ $interview->location }}
@endif

@if($interview->type === 'video')
Please ensure you have a stable internet connection and a quiet environment for the interview.
@endif

@component('mail::button', ['url' => route('applications.show', $interview->application)])
View Interview Details
@endcomponent

Best regards,  
{{ config('app.name') }} Team
@endcomponent