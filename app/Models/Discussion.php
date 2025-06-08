<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\MentionNotification;

class Discussion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'title',
        'content',
        'created_by',
        'is_pinned'
    ];

    protected $casts = [
        'is_pinned' => 'boolean'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(DiscussionReply::class);
    }

    public function mentions(): MorphMany
    {
        return $this->morphMany(Mention::class, 'mentionable');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($discussion) {
            // Extract mentions from content and create mention records
            preg_match_all('/@(\w+)/', $discussion->content, $matches);
            if (!empty($matches[1])) {
                $usernames = $matches[1];
                $users = User::whereIn('username', $usernames)->get();
                
                foreach ($users as $user) {
                    $discussion->mentions()->create([
                        'user_id' => $user->id
                    ]);
                    
                    // Notify mentioned user
                    $user->notify(new MentionNotification($discussion));
                }
            }
        });
    }
}