<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAppRequest extends FormRequest
{
    public function authorize()
    {
        // You can check user permissions here if needed
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'tagline' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('apps', 'slug')->ignore($this->app), // Assumes route-model binding for `app`
            ],
            'base_url' => 'required|url',
            'icon_url' => 'nullable|url',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The app name is required.',
            'slug.required' => 'The app slug is required.',
            'base_url.required' => 'The base URL is required.',
            'icon_url.url' => 'The icon URL must be a valid URL.',
            'description.string' => 'The description must be a string.',
            'status.in' => 'The status must be either active or inactive.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'app name',
            'slug' => 'app slug',
            'base_url' => 'base URL',
            'icon_url' => 'icon URL',
            'description' => 'description',
            'status' => 'status',
        ];
    }
}
