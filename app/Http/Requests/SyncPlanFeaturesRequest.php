<?php
// app/Http/Requests/SyncPlanFeaturesRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SyncPlanFeaturesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Add authorization logic if needed
    }

    public function rules(): array
    {
        return [
            'features' => 'required|array|min:1',
            'features.*.id' => 'required|exists:features,id',
            'features.*.value' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'features.required' => 'Please provide at least one feature.',
            'features.*.id.required' => 'Feature ID is required.',
            'features.*.id.exists' => 'One or more feature IDs are invalid.',
            'features.*.value.required' => 'Each feature must have a value.',
        ];
    }
}
