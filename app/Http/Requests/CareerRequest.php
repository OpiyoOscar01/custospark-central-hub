<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CareerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Add authorization logic if needed
    }

    public function rules(): array
    {
        return [
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'type'           => 'required|array|min:1',
            'type.*'         => 'required|string|in:Full-Time,Part-Time,Contract,Internship,Remote,On-Site',
            'positions'      => 'required|integer|min:1',
            'deadline'       => 'required|date|after:today',
            'requirements'   => 'required|array|min:1',
            'requirements.*' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required'           => 'Please select at least one job type',
            'type.*.in'               => 'Invalid job type selected',
            'positions.min'           => 'Number of positions must be at least 1',
            'deadline.after'          => 'Deadline must be a future date',
            'requirements.required'   => 'At least one job requirement is required',
            'requirements.*.required' => 'CompanyJob requirement cannot be empty',
        ];
    }
}
