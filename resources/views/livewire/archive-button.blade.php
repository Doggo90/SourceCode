<div>
    @if(Auth::user()?->role == 'admin')
        <div class="form-check form-switch">
            <input wire:click="toggleArchive()" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" wire:model.live="post->is_archived" {{ ($post->is_archived == 1) ? 'checked' : '' }}>
            <label class="form-check-label" for="flexSwitchCheckDefault">{{ ($post->is_archived == 1) ? 'Un-Archive' : 'Archive' }}
            </label>
        </div>
    @endif
</div>
