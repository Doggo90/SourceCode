
<div class="card">
    <br>
    <div class="container-fluid d-flex justify-content-center">
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
            <label class="btn btn-outline-success" for="btnradio1" wire:click="setSortBy('created_at')">Latest</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
            <label class="btn btn-outline-success" for="btnradio2" wire:click="setSortBy('likes_count')">Upvotes</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
            <label class="btn btn-outline-success" for="btnradio3" wire:click="setSortBy('body')">Comments</label>
          </div>
    </div>
    <div class="card mt-2">
        <div class="card-body">
            @foreach ($posts as $post)
                @if ($post->is_archived == 1 && $post->is_approved)
                    <a href="/post/{{ $post->id }}">
                            <div class="card z-index-2 mb-2" style="max-height: 200px; overflow: hidden;">
                                <div class="card-header pb-0 pt-3 bg-transparent d-flex justify-content-start mx-3">
                                    <div class=" d-flex justify-content-between">
                                        <img class="img-fluid rounded-circle" style="width: 2rem; height: 2rem;"
                                            src="/img/no-image.png"
                                            {{-- {{ !empty($post->author->photo) ? url($post->author->photo) : url('/img/no-image.png') }}" --}}
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
                                        <i class="me-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                                <path fill-rule="evenodd" d="M11.47 2.47a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 1 1-1.06 1.06l-6.22-6.22V21a.75.75 0 0 1-1.5 0V4.81l-6.22 6.22a.75.75 0 1 1-1.06-1.06l7.5-7.5Z" clip-rule="evenodd" />
                                              </svg>

                                        </i>
                                        <span class="font-weight-bold">{{ $post->likes()->count() }}</span>
                                        <i class="ms-3 me-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                                <path fill-rule="evenodd" d="M4.848 2.771A49.144 49.144 0 0 1 12 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 0 1-3.476.383.39.39 0 0 0-.297.17l-2.755 4.133a.75.75 0 0 1-1.248 0l-2.755-4.133a.39.39 0 0 0-.297-.17 48.9 48.9 0 0 1-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97ZM6.75 8.25a.75.75 0 0 1 .75-.75h9a.75.75 0 0 1 0 1.5h-9a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H7.5Z" clip-rule="evenodd" />
                                              </svg>

                                        </i>
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


</div>
