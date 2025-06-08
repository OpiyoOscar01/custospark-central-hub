<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => ['required', 'exists:projects,id'],
            'content' => ['required', 'string'],
            'type' => ['required', 'in:feedback,request,issue']
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.required' => 'Please select a project.',
            'project_id.exists' => 'The selected project is invalid.',
            'content.required' => 'Please provide your feedback.',
            'type.required' => 'Please select a feedback type.',
            'type.in' => 'The selected feedback type is invalid.'
        ];
    }
}