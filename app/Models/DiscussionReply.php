<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\MentionNotification;
use App\Notifications\NewDiscussionReplyNotification;

class DiscussionReply extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'discussion_id',
        'content',
        'user_id'
    ];

    public function discussion(): BelongsTo
    {
        return $this->belongsTo(Discussion::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mentions(): MorphMany
    {
        return $this->morphMany(Mention::class, 'mentionable');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            // Extract mentions from content and create mention records
            preg_match_all('/@(\w+)/', $reply->content, $matches);
            if (!empty($matches[1])) {
                $usernames = $matches[1];
                $users = User::whereIn('username', $usernames)->get();
                
                foreach ($users as $user) {
                    $reply->mentions()->create([
                        'user_id' => $user->id
                    ]);
                    
                    // Notify mentioned user
                    $user->notify(new MentionNotification($reply));
                }
            }

            // Notify discussion creator and participants
            $discussion = $reply->discussion;
            $participants = $discussion->replies()
                ->where('user_id', '!=', $reply->user_id)
                ->distinct()
                ->pluck('user_id');
            
            foreach ($participants as $userId) {
                User::find($userId)->notify(new NewDiscussionReplyNotification($reply));
            }
        });
    }
}