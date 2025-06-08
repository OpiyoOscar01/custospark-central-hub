<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResourceRequest extends FormRequest
{
    // public function authorize(): bool
    // {
    //     return true;
    // }

    // public function rules(): array
    // {
    //     return [
    //         'project_id' => ['required', 'exists:projects,id'],
    //         'name' => ['required', 'string', 'max:255'],
    //         'type' => ['required', 'in:tool,software,material'],
    //         'quantity' => ['required', 'integer', 'min:0'],
    //         'cost' => ['required', 'numeric', 'min:0']
    //     ];
    // }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // You can add authorization logic here (e.g. check roles)
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_url' => 'nullable|url', // Validating if file_url is a valid URL
            'resource_type' => 'required|in:document,video,link,template,guide', // Restrict resource type
            'visible_to_roles' => 'nullable|array',
            'visible_to_roles.*' => 'in:client,staff,admin,ceo', // Allow specific roles
        ];
    }

    /**
     * Get custom error messages for validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            
            'description.string' => 'The description must be a valid string.',
            
            'file_url.url' => 'The file URL must be a valid URL.',
            
            'resource_type.required' => 'The resource type is required.',
            'resource_type.in' => 'The resource type must be one of the following: document, video, link, template, or guide.',
            
            'visible_to_roles.array' => 'The visible to roles field must be an array.',
            'visible_to_roles.*.in' => 'Each role in the visible to roles must be one of the following: client, staff, admin, or ceo.',
        ];
    }

    /**
     * Get custom attribute names.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => 'resource title',
            'description' => 'resource description',
            'file_url' => 'file URL',
            'resource_type' => 'resource type',
            'visible_to_roles' => 'roles that can see the resource',
        ];
    }
}