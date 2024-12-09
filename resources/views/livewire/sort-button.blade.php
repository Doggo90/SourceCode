<div class="mt-0 mb-2">
    <style>
        .custom-button {
            margin: 0;
        }
    </style>
    <div class="container-fluid d-flex justify-content-center mb-2">
        <div x-data="{ query: '' }" id="search-box" class="container-fluid py-auto">
            <div class="input-group">
                <input class="form-control" x-model="query" type="text" wire:model.live.prevent.debounce.300ms="search"
                    name="search" id="search" placeholder="Search here...">
                {{-- <button  type="button"
                    class="btn btn-success py-auto custom-button">
                    Search
                </button> --}}
                <button x-on:click="$dispatch('search', { search: query })" type="button " class="py-auto focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-m px-2 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" style="margin: 0;">
                    <i class="fa fa-search ms-3 me-3"></i>
                  </button>
            </div>
        </div>
    </div>
    <div class="container-fluid d-flex justify-content-center mb-0">
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
            <label class="btn btn-outline-success mb-0" for="btnradio1" wire:click="setSortBy('created_at')">Latest</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
            <label class="btn btn-outline-success mb-0" for="btnradio2" wire:click="setSortBy('likes_count')">Upvotes</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
            <label class="btn btn-outline-success mb-0" for="btnradio3"
                wire:click="setSortBy('comments_count')">Comments</label>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-body">
            @foreach ($posts as $post)
                @if ($post->is_archived == 0 && $post->is_approved)
                    <a href="/post/{{ $post->id }}">
                            <div class="card z-index-2 mb-2" style="max-height: 200px; overflow: hidden;">
                                <div class="card-header pb-0 pt-3 bg-transparent d-flex justify-content-start mx-3">
                                    <div class=" d-flex justify-content-between">
                                        <img class="img-fluid rounded-circle" style="width: 2rem; height: 2rem;"
                                            src="{{ !empty($post->author->photo) ? url($post->author->photo) : url('/img/no-image.png') }}"
                                            alt="profile">
                                        <p class="text-capitalize text-bold ps-2">{{ $post->author->name }}</p>
                                    </div>
                                </div>
                                <div class="card-body d-flex justify-content-between mx-4  py-2" style="max-height: 100px; overflow: hidden; margin-bottom: 0; margin-left: 0; margin-right: 0;">
                                        <p class="text-uppercase fw-bold">
                                            {{ \Illuminate\Support\Str::limit(explode('å', $post->title)[0], $limit =40, $end = '...') }}
                                        </p>

                                </div>
                                <div class="card-footer d-flex justify-content-between p-3 mx-4 mt-0 mb-2 py-0" style="max-height: 100px; padding-top: 0; margin-top: 0;">
                                    <div class="d-flex">
                                        <i class="fa fa-arrow-up text-success me-3"></i>
                                        <span class="font-weight-bold">{{ $post->likes()->count() }}</span>
                                        <i class="fa fa-comment text-success ms-3 me-3"></i>
                                        <span class="font-weight-bold">{{ $post->comments->count() }}</span>
                                    </div>
                                    <div class="ms-5 d-flex">
                                        <i class="fa fa-clock text-success"></i>
                                        <span class="font-weight-bold text-sm mb-0 ms-2"> {{ $post->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                    </a>
                    {{-- <br> --}}
                @endif
            @endforeach
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-center inline-block">
                <style>
                    .pagination {
                        /* Custom pagination styles */
                    }

                    .pagination .page-link {
                        /* Custom page link styles */
                        background-color: #337ab7;
                        color: #fff;
                    }

                    .pagination .page-link:hover {
                        /* Custom hover styles */
                        background-color: #23527c;
                    }
                </style>
                {{ $posts->withQueryString()->links() }}
                {{-- {{ $posts->links('vendor.pagination.bootstrap-5') }} --}}
                {{-- {{ $posts->links('vendor.pagination.tailwind') }} --}}
            </div>
        </div>
    </div>
    {{-- @livewireScripts --}}
</div>
