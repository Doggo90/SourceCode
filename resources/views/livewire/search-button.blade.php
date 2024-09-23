<div class="input-group btn-group" role="group">
    <form wire:submit="search" class="input-group ">
        <div x-data = "{
            query: ''
        }" id="search-box">
            {{-- <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span> --}}
            <input class="input-group-text text-body" x-model="query" type="text" wire:model.live.debounce.300ms="search" name="search" id="search" placeholder="Search here...">
            <button x-on:click="$dispatch('search',{
                    search : query
                })"
                type="button" class="btn btn-success">
                Search
            </button>
        </div>
        {{-- <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
        <input type="text" wire:model.live="search" name="search" id="search" class="form-control" placeholder="Type here..."> --}}
    </form>
</div>
