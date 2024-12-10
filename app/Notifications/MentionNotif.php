<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Comment;
use App\Models\Reply;

class MentionNotif extends Notification
{
    use Queueable;
    public $model;
    public $comment;
    public $reply;
    /**
     * Create a new notification instance.
     */
    public function __construct($comment = null, $reply = null)
{
    if ($comment instanceof Comment) {
        $this->comment = $comment;
    }

    if ($reply instanceof Reply) {
        $this->reply = $reply;
    }
}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        $user = null;
        $photo = null;
        $model_id = null;
        $link = null;
        if ($this->comment instanceof Comment) {
            $user = $this->comment->user->name;
            $photo = $this->comment->user->photo;
            $model_id = $this->comment->getKey();
            $link = route('show', ['post' => $this->comment->post_id]);
        }

        if ($this->reply instanceof Reply) {
            $user = $this->reply->author->name;
            $photo = $this->reply->author->photo;
            $model_id = $this->reply->getKey();
            $link = route('show', ['post' => $this->reply->comment->post_id]);
        }
        // $user = $this->comment->user->name;
        // $photo = $this->comment->user->photo;
        // $model_id = $this->comment->getKey();
        // $link = route('show', ['post' => $this->comment->post_id]);
        return [
            'user' => $user,
            'photo' => $photo,
            'link' => $link,
            'type' => 'mention'
        ];
    }
}
