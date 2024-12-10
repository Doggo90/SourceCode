<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Xetaio\Mentions\Models\Traits\HasMentionsTrait;

class Reply extends Model
{
    use HasFactory;
    use HasMentionsTrait;
    protected $guarded=[];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
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
        return $this->belongsToMany(User::class, 'reply_user');
    }
}
