<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class MentionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public $mentionable)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $type = class_basename($this->mentionable);
        $project = $type === 'Discussion' 
            ? $this->mentionable->project 
            : $this->mentionable->discussion->project;
        
        $url = $type === 'Discussion'
            ? url("/projects/{$project->id}/discussions/{$this->mentionable->id}")
            : url("/projects/{$project->id}/discussions/{$this->mentionable->discussion_id}");

        $mentioner = $this->mentionable->user ?? $this->mentionable->creator;

        return (new MailMessage)
            ->subject("You were mentioned in a {$type}")
            ->line("{$mentioner->name} mentioned you in a {$type}.")
            ->line($this->mentionable->content)
            ->action('View Discussion', $url)
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        $type = class_basename($this->mentionable);
        $project = $type === 'Discussion' 
            ? $this->mentionable->project 
            : $this->mentionable->discussion->project;
        
        $mentioner = $this->mentionable->user ?? $this->mentionable->creator;

        return [
            'mentionable_id' => $this->mentionable->id,
            'mentionable_type' => $type,
            'project_id' => $project->id,
            'mentioner_name' => $mentioner->name,
            'content_preview' => Str::limit($this->mentionable->content, 100),
            'created_at' => $this->mentionable->created_at->toISOString(),
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}