<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Announcement;
use App\Models\Category;
use App\Models\Post;
use App\Models\Comments;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;

class NotifButton extends Component
{

    public $notifications;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        if (Auth::user()) {
            $this->notifications = Auth::user()->notifications;
        }
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->findOrFail($notificationId);

        // Mark the notification as read
        $notification->markAsRead();

        // Reload notifications
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notif-button');
    }
}
