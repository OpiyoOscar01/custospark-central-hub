<?php
namespace App\Repositories;

use App\Models\Feedback;

class FeedbackRepository
{
    public function store(array $data): Feedback
{
    return Feedback::create([
        'user_id' => $data['user_id'],
        'app_id' => $data['app_id'],
        'type' => $data['type'],
        'message' => $data['message'],
        'complaint_categories' => $data['complaint_categories'] ?? null,
        'attachments' => $data['attachments'] ?? null,
    ]);
}


    public function all()
    {
        return Feedback::latest()->get();
    }
}
