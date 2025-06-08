<?php
// app/Http/Requests/PlanRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $planId = $this->route('id');

        return [
            'app_id' => 'required|exists:apps,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:plans,slug,' . $planId . ',id,app_id,' . $this->input('app_id'),
            'price' => 'required|numeric|min:0',
            'plan_type' => 'required|in:free,trial,paid',
            'level' => 'required|numeric|min:0',
            'trial_days' => 'nullable|integer|min:0|max:365|required_if:plan_type,trial',
            'billing_cycle' => 'required|in:monthly,yearly',
            'description' => 'nullable|string',
            'is_popular' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'app_id.required' => 'The app is required.',
            'app_id.exists' => 'The selected app does not exist.',
            'name.required' => 'The plan name is required.',
            'name.string' => 'The plan name must be a string.',
            'name.max' => 'The plan name may not be greater than 255 characters.',
            'slug.required' => 'The slug is required.',
            'slug.string' => 'The slug must be a string.',
            'slug.max' => 'The slug may not be greater than 255 characters.',
            'slug.unique' => 'The slug has already been taken.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a number.',
            'price.min' => 'The price must be at least 0.',
            'plan_type.required' => 'The plan type is required.',
            'plan_type.in' => 'The selected plan type is invalid.',
            'trial_days.integer' => 'The trial days must be an integer.',
            'trial_days.min' => 'The trial days must be at least 0.',
            'trial_days.max' => 'The trial days may not be greater than 365.',
            'trial_days.required_if' => 'The trial days are required when the plan type is trial.',
            'billing_cycle.required' => 'The billing cycle is required.',
            'billing_cycle.in' => 'The selected billing cycle is invalid.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 255 characters.',
            'is_popular.boolean' => 'The is popular field must be true or false.',
            'is_popular.required' => 'The is popular field is required.',
            'is_popular.in' => 'The selected is popular is invalid.',
        ];
    }

    public function attributes()
    {
        return [
            'app_id' => 'App',
            'name' => 'Plan Name',
            'slug' => 'Slug',
            'price' => 'Price',
            'billing_cycle' => 'Billing Cycle',
            'description' => 'Description',
            'is_popular' => 'Is Popular',
            'plan_type' => 'Plan Type',
            'trial_days' => 'Trial Days',
        ];
    }
}
