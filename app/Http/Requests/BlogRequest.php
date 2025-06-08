<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization logic can be added here
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'author_id' => 'required|exists:users,id',
            'featured' => 'nullable|boolean'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The blog post must have a title.',
            'title.string' => 'The title must be a valid string.',
            'title.max' => 'The title cannot exceed 255 characters.',
            'content.required' => 'Please provide content for the blog post.',
            'content.string' => 'The content must be a valid string.',
            'category_id.exists' => 'The selected category is invalid.',
            'author_id.required' => 'An author must be specified for the blog post.',
            'author_id.exists' => 'The selected author is invalid.',
            'featured.boolean' => 'The featured field must be true or false.'
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'title' => 'blog title',
            'content' => 'blog content',
            'category_id' => 'category',
            'author_id' => 'author',
            'featured' => 'featured status'
        ];
    }
}
