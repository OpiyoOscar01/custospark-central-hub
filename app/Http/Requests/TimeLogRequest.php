<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimeLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'task_id' => ['required', 'exists:tasks,id'],
            'user_id' => ['required', 'exists:users,id'],
            'hours_worked' => ['required', 'numeric', 'min:0.1', 'max:24'],
            'date_logged' => ['required', 'date', 'before_or_equal:today'],
            'description' => ['nullable', 'string']
        ];
    }
}