<?php

namespace App\Notifications;

use App\Models\DiscussionReply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewDiscussionReplyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public DiscussionReply $reply)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $discussion = $this->reply->discussion;
        
        return (new MailMessage)
            ->subject("New reply in discussion: {$discussion->title}")
            ->line("{$this->reply->user->name} replied to a discussion you're participating in.")
            ->line($this->reply->content)
            ->action('View Discussion', url("/projects/{$discussion->project_id}/discussions/{$discussion->id}"))
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'reply_id' => $this->reply->id,
            'discussion_id' => $this->reply->discussion_id,
            'project_id' => $this->reply->discussion->project_id,
            'user_name' => $this->reply->user->name,
            'discussion_title' => $this->reply->discussion->title,
            'content_preview' => Str::limit($this->reply->content, 100),
            'created_at' => $this->reply->created_at->toISOString(),
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}