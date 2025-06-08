<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\StandardEmail as GenericNotification;

class NotificationService
{
    /**
     * Send a notification to specific user or all users
     */
    public function sendNotification($title, $mailBody, $targetType, $channel, $userId = null)
    {
        $sentAt = Carbon::now();

        if ($userId) {
            // Targeted user notification
            if ($channel === 'in_app') {
                $this->createNotification($userId, $title, $mailBody, $targetType, 'in_app', $sentAt);

            } elseif ($channel === 'email') {
                $this->sendEmail($userId, $title, $mailBody);

            } elseif ($channel === 'both') {
                $this->createNotification($userId, $title, $mailBody, $targetType, 'both', $sentAt);
                $this->sendEmail($userId, $title, $mailBody);
            }

        } else {
            // System-wide broadcast
            if ($channel === 'in_app') {
                $this->createSystemWideNotification($title, $mailBody, 'system', $sentAt, 'in_app');

            } elseif ($channel === 'email') {
                $this->emailAllUsers($title, $mailBody);

            } elseif ($channel === 'both') {
                $this->createSystemWideNotification($title, $mailBody, 'system', $sentAt, 'both');
                $this->emailAllUsers($title, $mailBody);
            }
        }
    }

    /**
     * Save notification for a specific user
     */
    protected function createNotification($userId, $title, $mailBody, $targetType, $channel, $sentAt)
    {
        Notification::create([
            'user_id'     => $userId,
            'title'       => $title,
            'message'     => $mailBody,
            'target_type' => $targetType,
            'channel'     => $channel,
            'sent_at'     => $sentAt,
        ]);
    }

    /**
     * Save a system-wide notification (no specific user)
     */
    protected function createSystemWideNotification($title, $mailBody, $targetType, $sentAt, $channel)
    {
        Notification::create([
            'title'       => $title,
            'message'     => $mailBody,
            'target_type' => $targetType,
            'channel'     => $channel,
            'sent_at'     => $sentAt,
        ]);
    }

    /**
     * Send email to a specific user with logging
     */
    protected function sendEmail($userId, $title, $mailBody)
    {
        $user = User::find($userId);

        if (!$user) {
            Log::warning("Attempted to send email to non-existent user ID: {$userId}");
            return;
        }

        try {
            Mail::to($user->email)->send(new GenericNotification($title, $mailBody));
            Log::info("Email successfully sent to {$user->email}.");
        } catch (\Exception $e) {
            Log::error("Failed to send email to {$user->email}. Error: " . $e->getMessage());
        }
    }

    /**
     * Send email to all users with error logging
     */
    protected function emailAllUsers($title, $mailBody)
    {
        User::all()->each(function ($user) use ($title, $mailBody) {
            try {
                Mail::to($user->email)->send(new GenericNotification($title, $mailBody));
                Log::info("Email successfully sent to {$user->email}.");
            } catch (\Exception $e) {
                Log::error("Failed to send email to {$user->email}. Error: " . $e->getMessage());
            }
        });
    }
}
