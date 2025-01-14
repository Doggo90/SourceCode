<?php

namespace App\Livewire;

use App\Notifications\ReplyMention;
use Livewire\Component;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Post;
use App\Models\User;
use App\Notifications\ReplyNotif;
use App\Notifications\MentionNotif;
use Xetaio\Mentions\Parser\MentionParser;

class ReplySection extends Component
{
    public Post $post;

    public Comment $comment;
    // public Reply $reply;
    public $body = '';
    public $search = '';
    public $results = [];
    public $mentionedUsers = [];

    // public function mount($reply)
    // {
    //     // $this->comment = $comment;

    //     $this->reply = $reply;
    // }
    public function addMentionedUser($email)
{
    $currMention = $this->mentionedUsers[] = $email;

    $mentionedUser = User::where('email', $email)->first();
    if ($mentionedUser) {
        preg_match_all('/\@\w+\b/', $this->body, $matches);
        $lastMention = end($matches[0]);
        $this->body = preg_replace('/' . preg_quote($lastMention, '/') . '/', '@' . $mentionedUser->name, $this->body, 1);
        // dd($this->comment_body);
    }
}
    public function createReply()
    {
        // dd($mentionedUsers);
        $this->validate([
            'body' => 'required | min:2',
        ]);
        $comments2 = Comment::where('post_id', $this->comment->id)->get();
        $reply = Reply::create([
            'user_id' => auth()->user()->id,
            'comment_id' => $this->comment->id,
            'body' => $this->body,
        ]);
        $parser = new MentionParser($reply);
        $content = $parser->parse($reply->body);
        // $content2 = substr($content, 1);
        $reply->body = $content;
        // $mentionedUsers = $reply->mentionsRelationship()->pluck('name');

        foreach ($this->mentionedUsers as $email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $reply->mentions($email);
            }
        }
        $reply->save();
        $this->dispatch('reply-created', $reply);
        // $this->dispatch('comment-created', $comment);

        // NOTIFICATION FOR REPLIES SENT TO USER
        if (auth()->user()->email != $this->comment->author->email) {
            $this->comment->author->notify(new ReplyNotif($reply));
        }
        preg_match_all(
            '/(?:^|\s)@(\w+)|(?:^|\s)(\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b)/',
            $reply->body,
            $matches,
        );
        $users = array_unique($matches[1]);
        if($users != null) {
            $mentionedUser = User::where(function ($query) use ($users) {
                foreach ($users as $user) {
                    $query
                        ->orWhere('name', 'like', "%$user%")
                        ->orWhere('email', 'like', "%$user%");
                }
            })->get();
            foreach ($mentionedUser as $result) {
                if (auth()->user()->email != $result->email) {
                    $result->notify(new ReplyMention($reply));
                    // dd($mentionedUser);
                }
            }
        }

        // Reset mentionedUsers array
        $this->mentionedUsers = [];
        $this->body = '';
        // toastr()->success('Reply posted!');
        flash('Replied', 'success');

    }

    public function mentionUser($email,Reply $reply){
        $mentionedUsers = [$email];
        // $mentionedUser = User::where('email', $email)->first();
        $allMentions = User::where(function ($query) use ($mentionedUsers) {
            foreach ($mentionedUsers as $user) {
                $query
                    // ->orWhere('name', 'like', "%$user%")
                    ->orWhere('email', 'like', "%$user%");
            }
        })->get();
        if ($allMentions) {
            preg_match_all('/\@\w+\b/', $this->body, $matches);
            $lastMention = end($matches[0]);
            $this->body = preg_replace('/' . preg_quote($lastMention, '/') . '/', '@' . $allMentions->name, $this->body, 1);
        }
    }

    public function render()
    {

        $replyCount = Reply::where('comment_id', $this->comment->id)->count();
        // $replies = Reply::mentionsRelationship()->withPivot('reply_id')->get();
        $replies = Reply::all();
        $allMentions = User::whereIn('email', $this->mentionedUsers)->get();

        return view('livewire.reply-section', compact('replies', 'replyCount', 'allMentions'));
    }
}
