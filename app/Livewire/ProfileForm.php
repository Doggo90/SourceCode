<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class ProfileForm extends Component
{

    public function render(User $user)
    {
        $user = User::find($user->id);
        return view('livewire.profile-form', compact('user'));
    }
}
