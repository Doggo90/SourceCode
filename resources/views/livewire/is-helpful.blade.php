<div>
    @if (Auth::user()?->name == $comment->post->author->name)
        <div class="form-check form-switch">
            <input wire:click="toggleHelpful()" class="form-check-input" type="checkbox"
                role="switch" id="flexSwitchCheckDefault"
                wire:model.live="post->is_archived"
                {{ $comment->is_helpful == 1 ? 'checked' : '' }}>
            <label class="form-check-label"
                for="flexSwitchCheckDefault">{{ $comment->is_helpful == 1 ? 'Unmark as helpful' : 'Mark as helpful' }}
            </label>
        </div>
    @endif
</div>
