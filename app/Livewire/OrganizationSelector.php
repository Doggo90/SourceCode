<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;

class OrganizationSelector extends Component
{
    public $errorMessage = '';

    public $selectedOrganizations = [];

    public $organizations;

    #[Validate('required|min:2')]
    public $bio;

    public function mount()
    {
        $this->organizations = Organization::pluck('nickname', 'id');
    }
    //     public function saveOrganizations()
    // {
    //     session()->put('selectedOrganizations', $this->selectedOrganizations);
    //     // redirect or use this session value later
    //     return redirect()->route('welcome.update');
    // }
    public function attachOrganizations(Request $request)
    {
        if (!$this->bio || empty($this->selectedOrganizations)) {
            $this->errorMessage = 'Missing Inputs Found!';
            return;
        }
        $attributes = $request->validate([
            'bio' => ['max:255'],
        ]);
        // dd($this->bio);

        auth()->user()->update([
                'bio' => $request->get($this->bio),
            ]);
        auth()
            ->user()
            ->organizations()
            ->sync($this->selectedOrganizations);

        return redirect('/dashboard')->with('success', 'Welcome!');
    }
    public function render()
    {
        return view('livewire.organization-selector');
    }
}
