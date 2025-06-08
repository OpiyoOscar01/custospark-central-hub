<?php
// app/Http/Requests/StoreSubscriptionRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'app_id' => 'required|exists:apps,id',
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|in:active,canceled,trial,grace,past_due',
            'trial_ends_at' => 'nullable|date',
            'ends_at' => 'nullable|date',
            'renews_at' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'A user must be selected.',
            'app_id.required' => 'An app must be specified.',
            'plan_id.required' => 'A subscription plan must be selected.',
            'status.in' => 'Invalid subscription status provided.',
        ];
    }
}

