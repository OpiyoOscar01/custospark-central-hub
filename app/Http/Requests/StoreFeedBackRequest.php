<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
   public function rules(): array
    {
        return [
            'type' => 'required|string|in:feature_request,complaint,bug_report,general_comment',
            'message' => 'required|string|min:10',
            'complaint_categories' => 'nullable|array',
            'complaint_categories.*' => 'string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:5120', // 5MB limit per file
            'source' => 'nullable|string',
            'user_id' => 'required|integer|exists:users,id',
            'app_id' => 'required|integer|exists:apps,id',
        ];
    }
}
