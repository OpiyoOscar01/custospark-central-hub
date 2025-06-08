<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'additional_information' => 'nullable|string|max:1000',
            'current_role' => 'nullable|string|max:255',
            'current_salary' => 'nullable|numeric|min:0',
            'current_salary_currency' => 'nullable|string|max:10',
            'years_of_experience' => 'nullable|string|min:0',
            'notice_period' => 'nullable|string|min:0',
            'status' => 'nullable|in:pending,reviewing,shortlisted,interview_scheduled,interviewed,offered,hired,rejected',
        ];
    }

    public function messages(): array
    {
        return [
            'resume.max' => 'The resume must not be larger than 5MB.',
            'cover_letter.max' => 'The cover letter must not be larger than 2MB.'
        ];
    }
}