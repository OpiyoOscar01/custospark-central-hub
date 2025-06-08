<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WeeklyProjectReport extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Project $project,
        public array $report
    ) {}

    // Specify the notification delivery channels
    public function via($notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Build the mail notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject("Weekly Project Report: {$this->project->name}")
            ->greeting("Hello {$notifiable->name},")
            ->line("Here's your weekly project report for {$this->project->name}.");

        // Project Progress Information
        $message->line('Project Progress:')
            ->line("• {$this->report['progress']['completed_tasks']} tasks completed this week")
            ->line("• Overall progress: {$this->report['progress']['total_progress']}%");

        // Milestone Information
        if (!empty($this->report['progress']['milestone_status'])) {
            $message->line('Milestone Status:');
            foreach ($this->report['progress']['milestone_status'] as $status => $count) {
                $message->line("• {$count} {$status} milestone(s)");
            }
        }

        // Time Tracking Information
        $message->line('Time Tracking:')
            ->line("• {$this->report['time_tracking']['hours_logged']} hours logged this week")
            ->line("• {$this->report['time_tracking']['billable_hours']} billable hours");

        // Budget Information
        $message->line('Budget Status:')
            ->line("• $" . $this->report['budget']['spent_this_week'] . " spent this week")
            ->line("• $" . $this->report['budget']['total_spent'] . " total spent")
            ->line("• $" . $this->report['budget']['budget_remaining'] . " remaining");

        // Risk Information
        $message->line('Risk Status:')
            ->line("• {$this->report['risks']['new_risks']} new risks identified")
            ->line("• {$this->report['risks']['resolved_risks']} risks resolved")
            ->line("• {$this->report['risks']['high_priority_risks']} high-priority risks requiring attention");

        // Add the call to action
        $message->action('View Project Details', url("/projects/{$this->project->id}"))
            ->line('Thank you for using our application!');

        return $message;
    }

    /**
     * Build the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'project_id' => $this->project->id,
            'project_name' => $this->project->name,
            'report_date' => now(),
            'progress' => $this->report['progress'],
            'time_tracking' => $this->report['time_tracking'],
            'budget' => $this->report['budget'],
            'risks' => $this->report['risks']
        ];
    }

    /**
     * Build the broadcast message for the notification.
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'type' => 'weekly_report',
            'project_id' => $this->project->id,
            'project_name' => $this->project->name,
            'report_date' => now(),
            'progress' => $this->report['progress']['total_progress'],
            'completed_tasks' => $this->report['progress']['completed_tasks'],
            'hours_logged' => $this->report['time_tracking']['hours_logged'],
            'budget_remaining' => $this->report['budget']['budget_remaining']
        ]);
    }
}
