<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'responsibilities' => 'required|string',
            'location' => 'required|string|max:255',
            'type' => 'required|in:full-time,part-time,contract',
            'experience_level' => 'required|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gt:salary_min',
            'salary_currency' => 'required|string|size:3',
            'is_remote' => 'boolean',
            'department' => 'required|string|max:255',
            'positions_available' => 'required|integer|min:1',
            'deadline' => 'nullable|date|after:today',
            'status' => 'required|in:draft,published,closed'
        ];
    }
}