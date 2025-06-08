<?php
// app/Http/Requests/StoreInvoiceRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;  // Adjust as needed based on user permissions
    }

    public function rules()
    {
        return [
            'subscription_id' => 'required|exists:subscriptions,id',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:paid,unpaid,failed',
            'issued_at' => 'required|date',
            'due_at' => 'required|date|after:issued_at',
            'payment_id' => 'nullable|exists:payments,id',
            'pdf_url' => 'nullable|url',
        ];
    }

    public function messages()
    {
        return [
            'subscription_id.required' => 'The subscription ID is required.',
            'subscription_id.exists' => 'The specified subscription does not exist.',
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The specified user does not exist.',
            'amount.required' => 'The amount is required.',
            'amount.numeric' => 'The amount must be a valid number.',
            'status.required' => 'The status is required.',
            'status.in' => 'The status must be one of the following: paid, unpaid, failed.',
            'issued_at.required' => 'The issue date is required.',
            'due_at.required' => 'The due date is required.',
            'due_at.after' => 'The due date must be after the issue date.',
            'payment_id.exists' => 'The specified payment does not exist.',
            'pdf_url.url' => 'The PDF URL must be a valid URL.',
        ];
    }
}

