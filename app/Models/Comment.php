<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Xetaio\Mentions\Models\Traits\HasMentionsTrait;

class Comment extends Model
{
    use HasFactory;
    use HasMentionsTrait;
    protected $guarded=[];

    protected static function booted()
    {
        static::created(function ($comment) {
            $comment->post->comments_count++;
            $comment->post->save();
        });
    }
    public function reply(): HasMany
    {
        return $this->hasMany(Reply::class , 'comment_id');
    }
    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
                // REPUTATION IF A COMMENT IS CREATED
    protected static function boot()
    {
        parent::boot();

        static::created(function ($comment) {
            // Increment the reputation of the user who created the comment.
            $user = $comment->user;
            $user->increment('reputation', 1);
            if($comment->is_helpful === true){
                $user->increment('reputation', 2);
            }
        });
    }
    public function mentions($email)
    {
        // Find the user with the given email
        $user = User::where('email', $email)->first();

        if ($user) {
            // Attach the user to the reply's mentions
            $this->mentionsRelationship()->attach($user->id);
        }
    }

    public function mentionsRelationship()
    {
        return $this->belongsToMany(User::class, 'comment_user');
    }
}
