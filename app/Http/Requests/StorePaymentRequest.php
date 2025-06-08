<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// app/Http/Requests/StorePaymentRequest.php

class StorePaymentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'subscription_id' => ['required', 'exists:subscriptions,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'method' => ['required', 'string'],
            'status' => ['required', 'in:successful,failed,pending'],
            'transaction_id' => ['nullable', 'string'],
            'paid_at' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'User is required.',
            'subscription_id.required' => 'Subscription is required.',
            'amount.required' => 'Amount must be provided.',
            'status.in' => 'Invalid payment status.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

