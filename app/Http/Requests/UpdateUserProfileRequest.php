<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // or add authorization logic
    }

  public function rules(): array
    {  return [
            'first_name'     => 'required|string|max:50',
            'last_name'      => 'required|string|max:50',
            'phone'          => 'nullable|string|max:20',
            'preferred_currency' => 'required|string|size:3', // ISO 4217 currency code
            'sex'            => 'nullable|in:male,female,other',
            'date_of_birth'  => 'nullable|date|before:today',
            'country'        => 'nullable|string|max:100',
            'city'           => 'nullable|string|max:100',
            'address'        => 'nullable|string|max:255',
            'language'       => 'nullable|string|max:50',
            'timezone'       => 'nullable|string|max:100',
            'bio'            => 'nullable|string|max:1000',
            'website'        => 'nullable|url|max:255',
            'avatar'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // 2MB max
        ];
    }
   

    public function messages(): array
    {
        return [
            'avatar.image' => 'The avatar must be an image.',
            'avatar.mimes' => 'Only jpeg, png, jpg, gif, webp formats are allowed.',
            'avatar.max'   => 'The avatar must not be larger than 2MB.',
             'first_name.required' => 'First name is required.',
            'last_name.required'  => 'Last name is required.',
            'phone.max'           => 'Phone number cannot exceed 20 characters.',
        ];
    }
}

    

