<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => ['required', 'exists:projects,id'],
            'file' => ['required', 'file', 'max:10240'], // 10MB max file size
            'uploaded_by' => ['required', 'exists:users,id']
        ];
    }

    public function messages(): array
    {
        return [
            'file.max' => 'The file size cannot exceed 10MB.',
        ];
    }
}