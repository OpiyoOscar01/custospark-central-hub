<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules= [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'status' => 'nullable|in:pending,scheduled,completed,cancelled',
            'country_code' => 'nullable|string|max:10',
            'custom_country_code' => 'nullable|string|max:10',
            'phone' => 'required|string|max:20',
            'timezone' => 'required|timezone',
        'preferred_date' => [
    'required',
    'date',
            function ($attribute, $value, $fail) {
                $dayName = \Carbon\Carbon::parse($value)->format('l'); // Gets full day name like Monday
                $allowedDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                if (!in_array($dayName, $allowedDays)) {
                    $fail('The ' . $attribute . ' must be a day between Monday and Saturday.');
                }
            },
        ],

            'preferred_start' => 'required|date_format:H:i',
            'preferred_end' => 'required|date_format:H:i|after:preferred_start',
            'meeting_type' => 'required|in:video,phone,in_person',
            'organization' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:1000',
        ];
        return $rules;
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Please enter your full name.',
            'full_name.max' => 'Your full name may not be greater than 255 characters.',
            'email.required' => 'We need your email address to contact you.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Your email may not be greater than 255 characters.',
            'phone.required' => 'Please enter your phone number.',
            'phone.max' => 'Phone number can be up to 20 characters only.',
            'country_code.max' => 'Country code may not be greater than 10 characters.',
            'custom_country_code.max' => 'Custom country code may not be greater than 10 characters.',
            'timezone.required' => 'Please select your time zone.',
            'timezone.timezone' => 'The selected time zone is invalid.',
            'preferred_days.*.in' => 'Please select valid preferred days.',
            'preferred_start.date_format' => 'Start time must be in HH:MM format.',
            'preferred_end.date_format' => 'End time must be in HH:MM format.',
            'preferred_end.after' => 'End time must be after start time.',
            'meeting_type.required' => 'Please select your preferred meeting format.',
            'meeting_type.in' => 'Selected meeting type is not valid.',
            'organization.max' => 'Organization name may not be greater than 255 characters.',
            'message.max' => 'Your message may not exceed 1000 characters.',
        ];
    }
}
