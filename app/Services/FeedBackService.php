<?php
namespace App\Services;

use App\Repositories\FeedBackRepository;
    use Illuminate\Support\Facades\Storage;


class FeedBackService
{
    protected FeedBackRepository $repo;

    public function __construct(FeedBackRepository $repo)
    {
        $this->repo = $repo;
    }


public function submitFeedback(array $data)
{
    // Save attachments first
    $attachments = [];
    if (!empty($data['attachments'])) {
        foreach ($data['attachments'] as $file) {
            $attachments[] = $file->store('feedback_attachments', 'public');
        }
    }

    return $this->repo->store([
        'user_id' => $data['user_id'],
        'app_id' => $data['app_id'],
        'type' => $data['type'],
        'message' => $data['message'],
        'complaint_categories' => $data['complaint_categories'],
        'attachments' => $attachments,
        'source' => $data['source'],
    ]);
}


    public function listAll()
    {
        return $this->repo->all();
    }
}
