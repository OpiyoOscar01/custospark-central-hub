<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppRequest extends FormRequest
{public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:apps,slug|max:255',
            'base_url' => 'required|url',
            'tagline' => 'required|string|max:255',
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
            'base_url.tagline' => 'The is tagline is required.',
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
