@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid">
        <div class="row">

            {{-- START POSTS LOOPINGS --}}
            <div class="col-lg-9 mb-lg-0 mb-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Post title-->
                                <h2 class="fw-bolder mb-1">{{$post->title}}</h2>
                                {{-- @php
                                    dd($post1);
                                @endphp --}}
                                <ul class="flex list-inline mb-0">
                                    @foreach($post1->categories as $category)
                                    <li class="badge bg-secondary text-decoration-none link-light list-inline-item">
                                        <a href="/category/{{$category->id}}" style="text-decoration: none; color:white; ">
                                        {{$category->name}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                <livewire:archive-button :post="$post" />
                                <!-- Post meta content-->
                                <div class="mt-0 pt-0">
                                    <small>Tags: </small>
                                    @foreach ($tags as $tag)
                                    <a href="/tag/{{ $tag }}">
                                        <span>
                                            {{ $tag }}
                                        </span>
                                    </a>,
                                    @endforeach
                                </div>
                                <div class="text-muted fst-italic mb-2 d-flex align-items-center justify-content-start">
                                    <span class="d-flex align-items-center gap-1">
                                        <p class="mb-0">{{$post->created_at->diffForHumans()}} by</p>
                                        <a href="/profile/{{$post->author->id}}" class="d-flex align-items-center gap-1">
                                            {{ \Illuminate\Support\Str::limit(implode(' ', array_slice(explode(' ', $post->author->name), 0, 2)), 15, '') }}

                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                            </svg>
                                            {{$post->author->reputation}}
                                        </a>
                                    </span>
                                </div>

                                <!-- Post categories-->
                                    {{-- <x-post-tags :tagsCsv="$post->tags"/> --}}

                            </div>
                            <div class="card-body">
                                <p class="fs-5 mb-4">
                                    {{$post->body}}
                                </p>
                            </div>
                            <div class="card-footer p-3" style="max-height: 60px; ">
                                <div class="d-flex align-items-center gap-2">
                                    <livewire:upvote :key="$post->id" :$post />

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M4.848 2.771A49.144 49.144 0 0 1 12 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 0 1-3.476.383.39.39 0 0 0-.297.17l-2.755 4.133a.75.75 0 0 1-1.248 0l-2.755-4.133a.39.39 0 0 0-.297-.17 48.9 48.9 0 0 1-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97ZM6.75 8.25a.75.75 0 0 1 .75-.75h9a.75.75 0 0 1 0 1.5h-9a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H7.5Z" clip-rule="evenodd" />
                                      </svg>

                                    <!-- Comments Count -->
                                    <span class="font-weight-bold">{{ $post->comments->count() }}</span>
                                </div>

                            </div>
                            <br>
                        </div>
                        <!-- Comments section-->

                        <livewire:comment-section :key="$post->id" :$post />

                    </div>
                </div>

            </div>
            {{-- END POSTS LOOPINGS --}}

            {{-- RIGHT SIDE COLUMN (ANNOUNCEMENTS AND CATEGORIES ETC.) --}}
            <div class="col-lg-3">
                @include('components.announcements')
            </div>


        </div>
        <div class="row">
            <div class="col-lg-7 mb-lg-0 mb-4">
            </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection


