<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => ['nullable', 'exists:projects,id'],
            'task_id' => ['nullable', 'exists:tasks,id'],
            'user_id' => ['required', 'exists:users,id'],
            'message' => ['required', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            'message.required' => 'The message content cannot be empty.',
        ];
    }
}