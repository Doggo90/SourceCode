<div class="mt-0 mb-2">
    <style>
        .custom-button {
            margin: 0;
        }
    </style>
    <div class="container-fluid d-flex justify-content-center mb-2">
        <div x-data="{ query: '' }" id="search-box" class="container-fluid py-auto">
            <div class="input-group">

                <input class="form-control text-md" x-model="query" type="text" wire:model.live.prevent.debounce.300ms="search"
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
                                    @php
                                    $badge = '';
                                    switch (true) {
                                        case $post->author->reputation >= 500:
                                            $badge = 'Expert';
                                            $badgeColor = '#FFD700'; // Gold
                                            $textColor = 'black';
                                            break;
                                        case $post->author->reputation >= 200:
                                            $badge = 'Active Contributor';
                                            $badgeColor = '#28a745'; // Green
                                            $textColor = 'white';
                                            break;
                                        case $post->author->reputation >= 100:
                                            $badge = 'Researcher';
                                            $badgeColor = '#00008B'; // Dark Blue
                                            $textColor = 'white';
                                            break;
                                        case $post->author->reputation >= 50:
                                            $badge = 'Mentor';
                                            $badgeColor = '#800080'; // Purple
                                            $textColor = 'white';
                                            break;
                                        case $post->author->reputation >= 10:
                                            $badge = 'Collaborator';
                                            $badgeColor = '#FF8C00'; // Orange
                                            $textColor = 'white';
                                            break;
                                        case $post->author->reputation >= 0:
                                            $badge = 'Newcomer';
                                            $badgeColor = '#87CEEB'; // Light Blue
                                            $textColor = 'white';
                                            break;
                                        default:
                                            $badge = '';
                                    }
                                @endphp
                                    <div class="d-flex justify-content-between align-items-center">
                                        <!-- Profile Image with Badge -->
                                        <div style="position: relative; display: inline-block;">
                                            <img class="img-fluid" style="width: 2rem; height: 2rem; border-radius: 50%;"
                                                src=" {{ !empty($post->author->photo) ? url($post->author->photo) : url('/img/no-image.png') }}"
                                                alt="profile">

                                            <!-- Badge Circle -->
                                            @if ($badge)
                                                <span style="position: absolute; bottom: -2px; right: -2px; width: 12px; height: 12px; background-color: {{ $badgeColor }}; color: {{ $textColor }}; border-radius: 50%; border: 1px solid white; display: flex; align-items: center; justify-content: center; font-size: 0.5rem; font-weight: bold;">
                                                    {{ substr($badge, 0, 1) }} <!-- Display first letter of the badge -->
                                                </span>
                                            @endif
                                        </div>

                                        <!-- User Name -->
                                        <p class="text-capitalize text-bold ps-2 mb-0">{{ $post->author->name }}</p>
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
    {{-- @livewireScripts --}}
</div>
