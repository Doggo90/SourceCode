<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Attributes\On;
use App\Notifications\CommentNotif;
use App\Notifications\MentionNotif;
use Livewire\Attributes\Url;
use Xetaio\Mentions\Parser\MentionParser;

class CommentSection extends Component
{
    public Post $post;

    public $comment_body = '';
    public $search = '';
    public $results = [];
    public $mentionedUsers = [];
    public function addMentionedUser($email)
{
    $currMention = $this->mentionedUsers[] = $email;

    $mentionedUser = User::where('email', $email)->first();
    if ($mentionedUser) {
        preg_match_all('/\@\w+\b/', $this->comment_body, $matches);
        $lastMention = end($matches[0]);
        $this->comment_body = preg_replace('/' . preg_quote($lastMention, '/') . '/', '@' . $mentionedUser->name, $this->comment_body, 1);
        // dd($this->comment_body);
    }
}
    public function createComment()
    {
        $this->validate([
            'comment_body' => 'required | min:2',
        ]);
        $comments2 = Comment::where('post_id', $this->post->id)->get();
        if ($comments2->where('user_id', auth()->user()->id)->count() > 0) {
            toastr()->error('You already commented on this post.');
        } else {
            $comment = Comment::create([
                'user_id' => auth()->user()->id,
                'post_id' => $this->post->id,
            'comment_body' => $this->comment_body,
            ]);

            //
            // dd($content);
            $parser = new MentionParser($comment);
            $content = $parser->parse($comment->comment_body);
            // $content2 = substr($content, 1);
            $comment->comment_body = $content;
            foreach ($this->mentionedUsers as $email) {
                $user = User::where('email', $email)->first();
                if ($user) {
                    $comment->mentions($email);
                }
            }
            $comment->save();
            $this->dispatch('comment-created', $comment);
            if (auth()->user()->email != $this->post->author->email) {
                $this->post->author->notify(new CommentNotif($comment));
            }
            // if (auth()->user()->email != $this->post->author->email) {
                //search the $comment.body for any matches in users table using regex
                // if there is a match, send a notif to that user.
            preg_match_all(
                '/(?:^|\s)@(\w+)|(?:^|\s)(\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b)/',
                $comment->comment_body,
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
                        $result->notify(new MentionNotif($comment));
                        // dd($matchedUsers);
                    }
                }
            }
            $this->mentionedUsers = [];
            $this->comment_body = '';
            flash('Comment posted.', 'success');
        }
    }
    public function mentionUser($email,Comment $comment){

        $mentionedUser = User::where('email', $email)->first();
        if ($mentionedUser) {
            preg_match_all('/\@\w+\b/', $this->comment_body, $matches);
            $lastMention = end($matches[0]);
            $this->comment_body = preg_replace('/' . preg_quote($lastMention, '/') . '/', '@' . $mentionedUser->name, $this->comment_body, 1);
            // dd($this->comment_body);
        }
    }
    public function resetSearch()
    {
        $this->search = '';
    }

    #[On('comment-created')]
    public function render()
    {
        // $users = User::where('name', 'like', '%' . $this->search . '%')->get();

        $comments = Comment::all();
        $flag = false;
        $results = User::where('name', 'like', '%' . substr($this->search, 1) . '%')
        ->orWhere('email', 'like', '%' . substr($this->search, 1) . '%')
        ->get();

        // dd($results);

        return view('livewire.comment-section', compact('results','comments', 'flag'));
    }
}
